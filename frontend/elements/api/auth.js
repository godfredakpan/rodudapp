import request from 'umi-request';
import { API_URL } from '../config';
import axios from 'axios';

export async function loginUser(credentials) {
  return request(`${API_URL}/login`, {
    method: 'post',
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Headers': '*',
    },
    body: JSON.stringify(credentials),
  });
}


export async function createUser(body) {
  try {
    
    const response = await axios.post(`${API_URL}/register`, body, {
      headers: {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Headers': '*',
      }
    });

    if (response.status !== 200) {
      console.log('Error response data:', response.data);
    }

    return response.data;  
  } catch (error) {
    console.log('Error creating Transaction:', error.message);
    
    if (error.response) {
      console.log('Error response data:', error.response.data.message);
      return error.response.data;
    }
    
    console.log('Full error details:', error);
  }
}
