
import React, { useEffect, useState } from 'react';
import { View, Text, StyleSheet, TouchableOpacity } from 'react-native';
import { getUser } from '../elements/user';
const Header =  ({ navigation }) => {

  const [user, setUser] = useState({});

  useEffect(() => {
    const fetchUser = async () => {
      const user = await getUser();
      console.log("user", user)
      setUser(user);
    };
    fetchUser();
  }, []);

  const initials = user?.name?.charAt(0);

  return (
    <View style={styles.header}>
      <View style={styles.profile}>
      <TouchableOpacity onPress={() => navigation.navigate('Profile')}>
        <Text style={styles.initials}>{initials}</Text>
        </TouchableOpacity>
      </View>
      <View style={styles.greetingContainer}>
      <Text style={styles.greeting}>Hello, {user?.name} 👋</Text>
      <Text style={styles.message}>Let us fulfil your logistics needs today</Text>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  header: {
    padding: 16,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  greetingContainer: {
    alignItems: 'flex-end',
    justifyContent: 'flex-end',
    flex: 1,
    marginLeft: 20,
    marginTop: 20,
    marginRight: 20,

  },
  greeting: {
    fontSize: 14,
    fontWeight: 'bold',
    color: '#000',
  },
  message: {
    fontSize: 10,
    color: '#888',
    marginTop: 8,

  },
  profile: {
    width: 40,
    height: 40,
    borderRadius: 20,
    backgroundColor: '#D9E2FF',
    alignItems: 'center',
    justifyContent: 'center',
  },
  initials: {
    fontSize: 18,
    color: '#8f1de9',
  },
  currency: {
    fontSize: 16,
  },
});

export default Header;
