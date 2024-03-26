import Axios from 'axios';
import SignupValidations from '../../../services/SignupValidations';
import {
    AUTH_ACTION,
    LOGIN_ACTION,
    AUTO_LOGIN_ACTION,
    LOGOUT_ACTION,
    SET_USER_TOKEN_DATA_MUTATION,
    SIGNUP_ACTION,
    AUTO_LOGOUT_ACTION,
    SET_AUTO_LOGOUT_MUTATION,
} from '../../storeconstants';

let timer = null;

export default {
    [LOGOUT_ACTION](context) {
        context.commit(SET_USER_TOKEN_DATA_MUTATION, {
            email: null,
            token: null,
            expiresIn: null,
            refreshToken: null,
            userId: null,
        });
        localStorage.removeItem('userData');
        if (timer) {
            clearTimeout(timer);
            timer = null;
        }
    },

    [AUTO_LOGOUT_ACTION](context) {
        context.dispatch(LOGOUT_ACTION);
        context.commit(SET_AUTO_LOGOUT_MUTATION);
    },

    async [LOGIN_ACTION](context, payload) {
        return context.dispatch(AUTH_ACTION, {
            ...payload,
            url: `http://127.0.0.1:7000/api/student/login`,
        });
    },

    async [SIGNUP_ACTION](context, payload) {
        return context.dispatch(AUTH_ACTION, {
            ...payload,
            url: `http://127.0.0.1:8000/api/register`,
        });
    },

    [AUTO_LOGIN_ACTION](context) {
        let userDataString = localStorage.getItem('userData');

        if (userDataString) {
            let userData = JSON.parse(userDataString);
            context.commit(SET_USER_TOKEN_DATA_MUTATION, userData);
            Axios.defaults.headers.common['Authorization'] = `Bearer ${userData.token}`;
        }
    },

    async [AUTH_ACTION](context, payload) {
        let postData = {
            email: payload.email,
            password: payload.password,
            returnSecureToken: true,
        };
        try {
            let response = await Axios.post(payload.url, postData);
            /*   console.log(response) */
            let tokenData = {
                email: response.data.student.email, // Kindly Replace the Student Model
                token: response.data.token,
                userId: response.data.student.id,
                userName: response.data.student.first_name
            };
            console.log(tokenData)
            localStorage.setItem('userData', JSON.stringify(tokenData));
            context.commit(SET_USER_TOKEN_DATA_MUTATION, tokenData);
            /*  Axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.idToken}`;
             if (tokenData.expiresIn > 0) {
                 timer = setTimeout(() => {
                     context.dispatch(AUTO_LOGOUT_ACTION);
                 }, tokenData.expiresIn);
             }
             return response; */
        } catch (error) {
            let errorMessage = error.response ? SignupValidations.getErrorMessageFromCode(error.response.data.error.errors[0].message) : 'An error occurred while logging in';
            throw errorMessage;
        }
    },
};