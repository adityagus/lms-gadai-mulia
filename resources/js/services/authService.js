import { apiInstance, apiInstanceAuth } from '../utils/axios';

export const login = async (data) => {
  try {
    const response = await apiInstanceAuth.post('/login', data);
    return response.data;
  } catch (error) {
    console.error('Error during login:', error);
    throw error;
  }
}

export const signOut = async () => {
  try {
    const response = await apiInstanceAuth.post('/logout');
    return response.data;
  } catch (error) {
    console.error('Error during logout:', error);
    throw error;
  }
}

  

export const getSession = async () => {
  try {
    const response = await apiInstanceAuth.get('/session');
    return response.data;
  } catch (error) {
    console.error('Error fetching session data:', error);
    throw error;
  }
}