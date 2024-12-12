import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, TouchableOpacity, ScrollView, Alert } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import Toast from 'react-native-toast-message';
import { getUser, verifyUserAccount } from '../elements/user';
import { useFocusEffect } from '@react-navigation/native';
import { sendResetPasswordNotification } from '../elements/api/notifications';
import Loading from '../components/Loading';
import ReactNativeBiometrics from 'react-native-biometrics';
import SvgIcons from '../elements/SvgIcons';

const MoreScreen = ({ navigation, handleLogoutFunction }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(false);
  const [biometricEnabled, setBiometricEnabled] = useState(false);

  useFocusEffect(() => {
    const fetchUser = async () => {
      const user = await getUser();
      setUser(user);
      const isBiometricEnabled = await AsyncStorage.getItem('isBiometricEnabled') === 'true';
      setBiometricEnabled(isBiometricEnabled);
    };
    fetchUser();
  });

  const verifyAccount = async () => {
    setLoading(true);
    const verifyUser = await verifyUserAccount(user?.id);

    if (verifyUser) {
      Toast.show({
        type: 'success',
        text1: 'Check your email',
        position: 'bottom',
        text2: 'Check your email for verification link.',
      });
    }

    setLoading(false);
  };

  const handleLogout = async () => {
    try {
      await AsyncStorage.removeItem('userData');
      await AsyncStorage.removeItem('isAuthenticated');
      await AsyncStorage.removeItem('isBiometricEnabled'); 
      Toast.show({
        type: 'success',
        text1: 'Logged out',
        text2: 'You have been logged out successfully.',
      });

      handleLogoutFunction();
    } catch (error) {
      Toast.show({
        type: 'error',
        text1: 'Error',
        text2: 'Something went wrong. Please try again.',
      });
    }
  };

  // Send reset password email
  const sendResetPassword = async () => {
    setLoading(true);
    const response = await sendResetPasswordNotification(user?.email);

    if (response) {
      Alert.alert('Success', 'Check your email for reset password link.');
    }

    setLoading(false);
  };

  const handleBiometricLogin = async () => {
    const rnBiometrics = new ReactNativeBiometrics();

    try {
      const result = await rnBiometrics.simplePrompt({ promptMessage: 'Authenticate' });

      if (result.success) {
        Toast.show({
          type: 'success',
          text1: 'Authentication Successful',
          text2: 'You are now logged in!',
        });
        // Navigate to the home screen or wherever needed
      } else {
        Toast.show({
          type: 'error',
          text1: 'Authentication Failed',
        });
      }
    } catch (error) {
      console.error(error);
      Toast.show({
        type: 'error',
        text1: 'Error',
        text2: 'Biometric authentication failed.',
      });
    }
  };

  const toggleBiometric = async () => {
    const newValue = !biometricEnabled;
    setBiometricEnabled(newValue);
    await AsyncStorage.setItem('isBiometricEnabled', JSON.stringify(newValue));
    Toast.show({
      type: 'success',
      text1: 'Biometric Authentication',
      text2: newValue ? 'Enabled' : 'Disabled',
    });
  };

  if (loading) {
    return <Loading />;
  }

  return (
    <ScrollView style={styles.container}>
      <View style={styles.section}>
        <Text style={styles.sectionHeader}>ACCOUNT</Text>
        <TouchableOpacity style={styles.item} onPress={() => navigation.navigate('Profile')}>
           <SvgIcons.User width={20} height={20} fill="#0051ba" />
          <Text style={styles.itemText}>Profile</Text>
        </TouchableOpacity>
        
        {/* This will be added if there is need to verify account */}
        {/* <TouchableOpacity style={styles.item}>
          <FontAwesome name="check-circle" size={20} color="#0051ba" />
          <Text style={styles.itemText}>Account Status</Text>
          {user && user.verified ? (
            <View style={styles.verified}>
              <Text style={styles.verifiedText}>verified</Text>
            </View>
          ) : (
            <TouchableOpacity onPress={() => verifyAccount()} style={styles.notVerified}>
              <Text style={styles.notVerifiedText}>not verified(press to verify)</Text>
            </TouchableOpacity>
          )}
        </TouchableOpacity> */}  
      </View>


      <View style={styles.section}>
        <Text style={styles.sectionHeader}>OTHERS</Text>
        {/* <TouchableOpacity onPress={() => sendResetPassword()} style={styles.item}>
           <SvgIcons.Security width={20} height={20} fill="#0051ba" /> 
          <Text style={styles.itemText}>Change Password</Text>
        </TouchableOpacity> */}
        <TouchableOpacity style={styles.item} onPress={() => navigation.navigate('Support')}>
          <SvgIcons.Support width={20} height={20} fill="#0051ba" />
          <Text style={styles.itemText}>Support</Text>
        </TouchableOpacity>
        <TouchableOpacity style={styles.item} onPress={handleLogout}>
            <SvgIcons.Logout width={20} height={20} fill="#0051ba" />
          <Text style={styles.itemText}>Logout</Text>
        </TouchableOpacity>
      </View>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingTop: 50,
    backgroundColor: '#f0f4ff',
  },
  header: {
    fontSize: 28,
    fontWeight: 'bold',
    margin: 20,
  },
  section: {
    marginVertical: 10,
    paddingHorizontal: 20,
  },
  sectionHeader: {
    fontSize: 14,
    color: '#888',
    marginBottom: 10,
  },
  item: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#fff',
    padding: 15,
    borderRadius: 8,
    marginBottom: 10,
  },
  itemText: {
    marginLeft: 10,
    fontSize: 14,
    color: '#000000',
    flex: 1,
  },
  verified: {
    backgroundColor: '#d4f5e9',
    borderRadius: 5,
    padding: 5,
  },
  verifiedText: {
    color: '#22c55e',
  },
  notVerified: {
    backgroundColor: '#fff8e1',
    borderRadius: 5,
    padding: 5,
  },
  notVerifiedText: {
    color: '#e67e22',
  },
});

export default MoreScreen;
