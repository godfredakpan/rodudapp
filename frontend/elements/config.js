import AsyncStorage from "@react-native-async-storage/async-storage";

export const API_URL = 'https://rodudapp.hrmaneja.com/api'; 


export const getToken = async () => {
    return await AsyncStorage.getItem('userToken')
}