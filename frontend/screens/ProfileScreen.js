import React, { useEffect, useState } from 'react';
import { View, Text, ScrollView, StyleSheet, TouchableOpacity, TextInput, ActivityIndicator } from 'react-native';
import { useFocusEffect } from '@react-navigation/native';
import { getUser, updateUser } from '../elements/user';
import Toast from 'react-native-toast-message';
import AsyncStorage from '@react-native-async-storage/async-storage';
import Loading from '../components/Loading';

const ProfileScreen = ({ navigation }) => {
  const [user, setUser] = useState({});
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [userId, setUserId] = useState('');
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    const fetchUser = async () => {
      const user = await getUser();
      console.log('user', user);
      if (user) {
        setUser(user);
        setUserId(user?.id);
        setName(user?.name || '');
        setAddress(user?.address || '');
        setLastName(user?.last_name || '');
        setFirstName(user?.first_name || '');
        setPhone(user?.phone || '');
        setGender(user?.gender || '');
      }
    };
    fetchUser();
  }, []);

  const updateMe = async () => {
    setLoading(true);
    const body = {
      name,
      id: userId,
    };

    try {
      const user = await updateUser(body);
      if (user) {
        setUser(user);
        await AsyncStorage.setItem('userData', JSON.stringify(user));

        Toast.show({
          type: 'success',
          text1: 'Profile updated!',
          visibilityTime: 3000,
          position: 'top'
        });
      }
    } catch (error) {
      Toast.show({
        type: 'error',
        text1: 'Profile update failed, please try again',
        visibilityTime: 3000,
        position: 'top',
      });
    } finally {
      setLoading(false);
    }
  };

  useFocusEffect(
    React.useCallback(() => {
      navigation.getParent()?.setOptions({
        tabBarStyle: { display: 'none' }
      });

      return () => {
        navigation.getParent()?.setOptions({
          tabBarStyle: {
            backgroundColor: '#8f1de9',
            borderTopColor: 'transparent',
            height: 80,
            paddingBottom: 20,
          }
        });
      };
    }, [navigation])
  );

  const initials = user?.name?.charAt(0) || '';

  if (loading) {
    return (
      <Loading/>
    );
  }

  return (
    <>
      <ScrollView style={styles.container}>
        <Toast />
        <View style={styles.headerContainer}>
          <Text style={styles.headerName}>{name}</Text>
          <Text style={styles.headerEmail}>{user?.email}</Text>
          <View style={styles.avatar}>
            <Text style={styles.avatarText}>{initials}</Text>
          </View>
        </View>
        <View style={styles.section}>
          <Text style={styles.sectionHeader}>PERSONAL DETAILS</Text>
          <View style={styles.detail}>
            <Text style={styles.label}>Name</Text>
            <TextInput
              style={styles.input}
              value={name}
              editable={false} 
            />
          </View>
        </View>

        <TouchableOpacity style={styles.updateButton} disabled onPress={updateMe}> 
          <Text style={styles.updateButtonText}>Update Account</Text>
        </TouchableOpacity>

        <TouchableOpacity style={styles.deleteButton} disabled>
          <Text style={styles.deleteButtonText}>Delete Account</Text>
        </TouchableOpacity>
      </ScrollView>
    </>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f0f4ff',
    padding: 20,
  },
  headerContainer: {
    alignItems: 'center',
    marginBottom: 20,
  },
  headerName: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#888',
  },
  headerEmail: {
    fontSize: 16,
    color: '#888',
  },
  avatar: {
    width: 50,
    height: 50,
    borderRadius: 25,
    backgroundColor: '#8f1de9',
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: 10,
  },
  avatarText: {
    color: '#fff',
    fontSize: 20,
    fontWeight: 'bold',
  },
  section: {
    marginBottom: 20,
  },
  sectionHeader: {
    fontSize: 16,
    color: '#888',
    marginBottom: 10,
  },
  detail: {
    backgroundColor: '#fff',
    padding: 15,
    borderRadius: 8,
    marginBottom: 10,
  },
  label: {
    fontSize: 14,
    color: '#888',
  },
  input: {
    fontSize: 16,
    color: '#8f1de9',
    borderBottomWidth: 1,
    borderBottomColor: '#ccc',
    padding: 5,
  },
  updateButton: {
    padding: 15,
    marginBottom: 10,
    backgroundColor: '#8f1de9',
    borderRadius: 8,
    alignItems: 'center',
  },
  updateButtonText: {
    color: '#ffff',
    fontSize: 16,
  },
  deleteButton: {
    padding: 15,
    borderWidth: 1,
    borderColor: '#f87171',
    borderRadius: 8,
    alignItems: 'center',
  },
  deleteButtonText: {
    color: '#f87171',
    fontSize: 16,
  },
});

export default ProfileScreen;
