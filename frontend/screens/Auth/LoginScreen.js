import React, { useState } from 'react';
import { View, Text, TextInput, StyleSheet, ImageBackground, TouchableOpacity } from 'react-native';
import Toast from 'react-native-toast-message';
import { loginUser } from '../../elements/api/auth';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { useFocusEffect } from '@react-navigation/native';
import Loading from '../../components/Loading';
import SvgIcons from '../../elements/SvgIcons';

const LoginScreen = ({ navigation, handleLogin }) => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [passwordVisible, setPasswordVisible] = useState(false);

  const handleLoginFunction = async () => {
    try {
      setLoading(true);

      if (!email || !password) {
        setLoading(false);
        Toast.show({
          type: 'error',
          text1: 'Error',
          text2: 'Please enter email and password',
        });
        return;
      }
      
      const response = await loginUser({ email, password });

      if (response) {
        console.log("response", response);
        const userData = response.user;

        await AsyncStorage.setItem('userData', JSON.stringify(userData));
        await AsyncStorage.setItem('userToken', `Bearer ${response.access_token}`);
        await AsyncStorage.setItem('isAuthenticated', 'true');

        setLoading(false);
        Toast.show({
          type: 'success',
          text1: 'Success',
          text2: 'Login successful',
        });
        handleLogin();
      } else {
        setLoading(false);
        Toast.show({
          type: 'error',
          text1: 'Error',
          text2: 'Invalid email or password',
        });
      }
    } catch (error) {
      console.log("error", error);
      setLoading(false);
      Toast.show({
        type: 'error',
        text1: 'Error',
        text2: 'Maybe password or email is incorrect, please try again',
        position: 'bottom'
      });
    }
  };


  useFocusEffect(
    React.useCallback(() => {
      const checkLogin = async () => {
        const token = await AsyncStorage.getItem('isAuthenticated');
        if (token) {
          navigation.reset({
            index: 0,
            routes: [{ name: 'Welcome' }],
          });
          console.log('User is authenticated');
        }
      };
      checkLogin();

      navigation.getParent()?.setOptions({
        tabBarStyle: { display: 'none' },
      });

      return () => {
        navigation.getParent()?.setOptions({
          tabBarStyle: {
            backgroundColor: '#8f1de9',
            borderTopColor: 'transparent',
            height: 80,
            paddingBottom: 20,
          },
        });
      };
    }, [navigation]),
  );

  if (loading) {
    return (
      <Loading />
    );
  }

  return (
    <ImageBackground
      source={require('../../assets/bg.png')}
      resizeMode="cover"
      imageStyle={{ resizeMode: 'cover' }}
      style={styles.container}
    >
      <View>
        <Text style={styles.subtitle}>Sign In to access your account and transactions</Text>

        <TextInput
          style={styles.input}
          placeholder="Email"
          value={email}
          placeholderTextColor={"#000000"}
          onChangeText={setEmail}
          keyboardType="email-address"
          autoCapitalize="none"
        />
        <View style={styles.passwordContainer}>
          <TextInput
            style={styles.passwordInput}
            placeholder="Password"
            placeholderTextColor={"#000000"}
            value={password}
            onChangeText={setPassword}
            secureTextEntry={!passwordVisible}
          />
          <TouchableOpacity style={styles.eyeIcon} onPress={() => setPasswordVisible(!passwordVisible)}>
            <SvgIcons.See width={24} height={24} fill="grey" />
          </TouchableOpacity>
        </View>

        <TouchableOpacity style={styles.button} onPress={handleLoginFunction}>
          <Text style={styles.buttonText}>Log In</Text>
        </TouchableOpacity>

        <TouchableOpacity onPress={() => navigation.navigate('SignUp')}>
          <Text style={styles.switchText}>Don't have an account? Sign Up</Text>
        </TouchableOpacity>

        <TouchableOpacity onPress={() => navigation.navigate('ForgotPassword')}>
          <Text style={styles.switchText}>Forgot Password?</Text>
        </TouchableOpacity>

        <Toast />
      </View>
    </ImageBackground>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    padding: 16,
    backgroundColor: '#f9f9f9',
  },
  subtitle: {
    fontSize: 16,
    marginBottom: 10,
    color: '#000000',
    textAlign: 'left',
  },
  input: {
    borderWidth: 1,
    color: '#8f1de9',
    borderColor: '#f8eefe',
    padding: 12,
    borderRadius: 8,
    marginBottom: 16,
    width: '100%',
  },
  passwordContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    borderWidth: 1,
    borderColor: '#f8eefe',
    borderRadius: 8,
    marginBottom: 16,
    width: '100%',
  },
  passwordInput: {
    flex: 1,
    color: '#8f1de9',
    padding: 12,
  },
  eyeIcon: {
    padding: 12,
  },
  button: {
    backgroundColor: '#8f1de9',
    padding: 16,
    borderRadius: 8,
    alignItems: 'center',
    marginVertical: 8,
  },
 
  buttonText: {
    color: '#fff',
    fontWeight: 'bold',
  },
  switchText: {
    marginTop: 16,
    textAlign: 'center',
    color: '#8f1de9',
  },
});

export default LoginScreen;
