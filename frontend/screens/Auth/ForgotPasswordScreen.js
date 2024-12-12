import React, {useState} from 'react';
import {View, Text, TextInput, StyleSheet, ImageBackground} from 'react-native';
import Toast from 'react-native-toast-message';
import {TouchableOpacity} from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import {useFocusEffect} from '@react-navigation/native';
import {sendResetPasswordNotification } from '../../elements/api/notifications';
import Loading from '../../components/Loading';
import { Alert } from 'react-native';

const ForgotPasswordScreen = ({navigation, handleLogin}) => {
  const [email, setEmail] = useState('');
  const [loading, setLoading] = useState(false);


  const sendResetPassword = async () => {
    setLoading(true);
    const response = await sendResetPasswordNotification(email);

    if(response){
      Alert.alert('Success', 'Check your email for reset password link.');
    }

    setLoading(false);
  }

  useFocusEffect(
    React.useCallback(() => {
      const checkLogin = async () => {
        const token = await AsyncStorage.getItem('isAuthenticated');
        if (token) {
          navigation.reset({
            index: 0,
            routes: [{name: 'Welcome'}],
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
    <View >
      <Text style={styles.subtitle}> Forgot Password</Text>

      <TextInput
        style={styles.input}
        placeholder="Email"
        value={email}
        placeholderTextColor={"#000000"}
        onChangeText={setEmail}
        keyboardType="email-address"
        autoCapitalize="none"
      />

      <TouchableOpacity style={styles.button} onPress={sendResetPassword}>
        <Text style={styles.buttonText}>Send Reset Link</Text>
      </TouchableOpacity>
      <TouchableOpacity onPress={() => navigation.navigate('SignUp')}>
        <Text style={styles.switchText}>Don't have an account? Sign Up</Text>
      </TouchableOpacity>
      <TouchableOpacity onPress={() => navigation.navigate('Login')}>
        <Text style={styles.switchText}>Remember password? Login</Text>
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
    // background image
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
  loaderStyle: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
});

export default ForgotPasswordScreen;
