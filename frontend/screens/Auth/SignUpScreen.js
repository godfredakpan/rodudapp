import React, { useState } from 'react';
import { View, Text, TextInput, StyleSheet, TouchableOpacity, Alert, ImageBackground } from 'react-native';
import { createUser } from '../../elements/api/auth';
import { useFocusEffect } from '@react-navigation/native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import Toast from 'react-native-toast-message';
import Loading from '../../components/Loading';
import SvgIcons from '../../elements/SvgIcons';

const SignUpScreen = ({ navigation , handleLogin}) => {
  const [email, setEmail] = useState('');
  const [firstName, setFirstName] = useState('');
  const [lastName, setLastName] = useState('');
  const [password, setPassword] = useState('');
  const [passwordVisible, setPasswordVisible] = useState(false);
  const [loading, setLoading] = useState(false);

  const handleSignUp = async () => {
    try {

      setLoading(true);
      if(!email || !password) {
        setLoading(false);
        Toast.show({
          type: 'error',
          text1: 'Error',
          text2: 'Please enter email and password',
        })
        return;
      }

      const body = {
        name: firstName + ' ' + lastName,
        email,
        password,
        password_confirmation: password,
      }

      const response = await createUser(body);

      if (response) {
        const userData = response.user;

        await AsyncStorage.setItem('userData', JSON.stringify(userData));

        await AsyncStorage.setItem('userToken', `Bearer ${response.access_token}`);

        await AsyncStorage.setItem('isAuthenticated', 'true');

        setLoading(false);
        Toast.show({
          type: 'success',
          text1: 'Success',
          text2: 'Sign up successful',
        })

        handleLogin();
      } else {
        setLoading(false);
        Toast.show({
          type: 'error',
          text1: 'Error',
          text2: 'Invalid email or password',
        })

      }
    } catch (error) {
      setLoading(false);
      Alert.alert('Error',  error.message);
    }
  };


  useFocusEffect(
    React.useCallback(() => {
      const checkLogin = async () => {
        const token = await AsyncStorage.getItem('isAuthenticated');
        if (token) {
          navigation.reset({
            index: 0,
            routes: [{name: 'HomeTab'}],
          });
          console.log('User is authenticated');
        }
      };

      checkLogin();
      navigation.getParent()?.setOptions({
        tabBarStyle: {display: 'none'},
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
      <Loading/>
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
      <Text style={styles.subtitle}>Create account to pay for all your bills and lots more</Text>
      <TextInput
        style={styles.input}
        placeholder="First Name"
        placeholderTextColor={"#000000"}
        value={firstName}
        onChangeText={setFirstName}
        keyboardType="text"
        autoCapitalize="none"
      />
      <TextInput
        style={styles.input}
        placeholder="Last Name"
        placeholderTextColor={"#000000"}
        value={lastName}
        onChangeText={setLastName}
        keyboardType="text"
        autoCapitalize="none"
      />
      <TextInput
        style={styles.input}
        placeholder="Email"
        placeholderTextColor={"#000000"}
        value={email}
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
        <TouchableOpacity
          style={styles.eyeIcon}
          onPress={() => setPasswordVisible(!passwordVisible)}
        >
          <SvgIcons.See width={24} height={24} fill="grey" />
        </TouchableOpacity>
      </View>
      <TouchableOpacity style={styles.button} onPress={handleSignUp}>
        <Text style={styles.buttonText}>Sign Up</Text>
      </TouchableOpacity>
      <TouchableOpacity onPress={() => navigation.navigate('Login')}>
        <Text style={styles.switchText}>Already have an account? Log In</Text>
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
  logo: {
    width: 100,
    height: 30,
    // top: -50,
    marginBottom: 16,
    alignSelf: 'center',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 5,
    textAlign: 'left',
  },
  subtitle: {
    fontSize: 16,
    marginTop: 50,
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

export default SignUpScreen;
