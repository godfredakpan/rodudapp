
import request from 'umi-request';
import { API_URL } from '../config';

export async function sendLoginNotification(userId) {
    return request(`${API_URL}/notification/send-signin-email/${userId}`, {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    });
}


export async function sendSignUpNotification(userId) {
    return request(`${API_URL}/notification/send-signup-email/${userId}`, {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    });
}

export async function sendResetPasswordNotification(email) {
    return request(`${API_URL}/notification/send-password-reset-email/${email}`, {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
        },
    });
}


