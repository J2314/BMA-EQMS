import SignupValidations from "@/services/SignupValidations";
import { LOGIN_ACTION, SET_USER_TOKEN_DATA_MUTATION, SIGNUP_ACTION } from "@/store/storeconstants";  
import Axios from 'axios';

//gagawin dito is about sa token katulad ng ginawa ni pana
//firebase muna database nito

export default {
    async [LOGIN_ACTION](context, payload) {
        let postData = {
            email: payload.email,
            password: payload.password,
            returnSecureToken: true,
        }
        let response = '';
        try {
            response = await Axios.post(
            'https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=AIzaSyA0uV6cs1uoWb2kE4W84JdHW8eslQJacA8'
        , 
        postData,
        );
    } catch(err) {
        let errorMessage = SignupValidations.getErrorMessageFromCode(
            err.response.data.error.errors[0].message, 
            );
        throw errorMessage
    }
    if (response.status === 200){
        context.commit(SET_USER_TOKEN_DATA_MUTATION, {
            email: response.data.email,
            token: response.data.idToken,
            expiresIn: response.data.expiresIn,
            refreshToken: response.data.refreshToken,
            userId: response.data.localId,
        })
    }
    },
    async [SIGNUP_ACTION](context, payload) {
        let postData = {
            email: payload.email,
            password: payload.password,
            returnSecureToken: true,
        }
        let response = '';
        try {
            response = await Axios.post(
            'https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=AIzaSyA0uV6cs1uoWb2kE4W84JdHW8eslQJacA8'
        , 
        postData,
        );
    } catch(err) {
        let errorMessage = SignupValidations.getErrorMessageFromCode(
            err.response.data.error.errors[0].message, 
            );
        throw errorMessage
    }
        if (response.status === 200){
            context.commit(SET_USER_TOKEN_DATA_MUTATION, {
                email: response.data.email,
                token: response.data.idToken,
                expiresIn: response.data.expiresIn,
                refreshToken: response.data.refreshToken,
                userId: response.data.localId,
            })
        }
    },
};

