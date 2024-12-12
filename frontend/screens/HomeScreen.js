import React, { useState } from 'react';
import { ScrollView, StyleSheet } from 'react-native';
import Header from '../components/Header';
import { useFocusEffect } from '@react-navigation/native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import Loading from '../components/Loading';
import RequestOrder from '../components/RequestOrder';
import Updates from '../components/Updates';


const HomeScreen = ({ navigation }) => {
  const [loading, setLoading] = useState(false);
  
  useFocusEffect(() => {
    const checkLogin = async () => {
      const token = await AsyncStorage.getItem('isAuthenticated');

      if (!token) {
        navigation.navigate('Login');
        console.log('User is not authenticated');
      }
      setLoading(false);
    };
    checkLogin();
    
  });

  if(loading) {
    return (
      <Loading/>
    );
  }

  return (
    <ScrollView style={styles.container}>
      <Header navigation={navigation} />
      <Updates />
      <RequestOrder />
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingTop: 20,
    backgroundColor: '#f3f6ff',
  },
});

export default HomeScreen;
