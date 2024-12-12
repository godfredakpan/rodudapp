import AsyncStorage from "@react-native-async-storage/async-storage";
import request from 'umi-request';
import { API_URL, getToken } from './config';


export async function getUserWallet() {
    return request(`${API_URL}/wallet/user`, {
        method: 'get',
        headers: {
            'Content-Type': 'application/json',
            Authorization: await getToken(),
        },
    });
}

export async function updateUser(body) {
    try {
      const response = await request(`${API_URL}/updateUser`, {
        
        method: 'post',
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*',
          'Access-Control-Allow-Headers': '*',
          Authorization: await getToken(),
        },
        body: JSON.stringify(body),
      });
      console.log('response', response)
      return response;
    } catch (error) {
      console.log('Error Updating user:', error);
      throw error; 
    }
  }

export async function fundWallet(body) {
    try {
      const response = await request(`${API_URL}/wallet/fund`, {
        method: 'post',
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*',
          'Access-Control-Allow-Headers': '*',
          Authorization: await getToken(),
        },
        body: JSON.stringify(body),
      });
      return response;
    } catch (error) {
      console.log('Error making Payment:', error);
      throw error; 
    }
  }


export const getUser = async () => {
    // const user = await AsyncStorage.getItem('userData');
    // if (user) {
    //   const userData = JSON.parse(user);
    //   return userData;
    // }
    // return null;
    return request(`${API_URL}/user`, {
      method: 'get',
      headers: {
          'Content-Type': 'application/json',
          Authorization: await getToken(),
      },
  });
}

// verifyAccount

export const verifyUserAccount = async (userId) => {
  return request(`${API_URL}/notification/send-verification-email/${userId}`, {
    method: 'get',
    headers: {
        'Content-Type': 'application/json',
        Authorization: await getToken(),
    },
});
}

