import React, { FC, useState, useEffect, useRef } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { createStackNavigator } from '@react-navigation/stack';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { Text, View, TouchableWithoutFeedback, AppState } from 'react-native';

import HomeScreen from './screens/HomeScreen';
import HistoryScreen from './screens/HistoryScreen';
import MoreScreen from './screens/MoreScreen';
import ProfileScreen from './screens/ProfileScreen';
import { BalanceProvider } from './elements/BalanceContext'; // if there was a wallet present
import SignUpScreen from './screens/Auth/SignUpScreen';
import LoginScreen from './screens/Auth/LoginScreen';
import ForgotPasswordScreen from './screens/Auth/ForgotPasswordScreen';
import OnboardingScreen from './screens/OnboardingScreen';
import SupportScreen from './screens/SupportScreen';
import Toast from 'react-native-toast-message';
import Loading from './components/Loading';
import OrderDetailsScreen from './screens/OrderDetailsScreen';
import SvgIcons from './elements/SvgIcons';

const Tab = createBottomTabNavigator();
const Stack = createStackNavigator();

const HomeStack = () => (
  <Stack.Navigator>
    <Stack.Screen name="Welcome" options={{ headerShown: false, title: ' ' }} component={HomeScreen} />
    <Stack.Screen name="Profile" options={{ headerShown: true, title: ' ' }} component={ProfileScreen} />
    <Stack.Screen name="OrderDetails" component={OrderDetailsScreen} />

  </Stack.Navigator>
);
// @ts-ignore
const MoreStack = ({ handleLogoutFunction }) => (
  <Stack.Navigator>
    <Stack.Screen options={{ headerShown: false }} name="More">
      {(props) => <MoreScreen {...props} handleLogoutFunction={handleLogoutFunction} />}
    </Stack.Screen>
    <Stack.Screen name="MyProfile" options={{ headerShown: true, title: ' ' }} component={ProfileScreen} />
    <Stack.Screen name="Support" options={{ headerShown: true, title: ' ' }} component={SupportScreen} />
  </Stack.Navigator>
);

// @ts-ignore
const AuthStack = ({ handleLogin, isOnboarded }) => (
  <Stack.Navigator>
    {isOnboarded === false && (
      <Stack.Screen name="Onboarding" component={OnboardingScreen} options={{ headerShown: false }} />
    )}
    <Stack.Screen options={{ headerShown: false }} name="Login">
      {(props) => <LoginScreen {...props} handleLogin={handleLogin} />}
    </Stack.Screen>
    <Stack.Screen options={{ headerShown: false }} name="SignUp">
      {(props) => <SignUpScreen {...props} handleLogin={handleLogin} />}
    </Stack.Screen>
    <Stack.Screen options={{ headerShown: false }} name="ForgotPassword">
      {(props) => <ForgotPasswordScreen {...props} handleLogin={handleLogin} />}
    </Stack.Screen>
  </Stack.Navigator>
);

const App = () => {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [hasOnboarded, setHasOnboarded] = useState(true);
  const [loading, setLoading] = useState(true);
  const inactivityTimer = useRef<NodeJS.Timeout | null>(null); 

  const INACTIVITY_TIMEOUT = 60 * 3000000; // the time can be updated to lesser time

  const handleLogin = async () => {
    setIsAuthenticated(true);
    setHasOnboarded(true);
  };

  const handleLogoutFunction = async () => {
    try {
      setIsAuthenticated(false);
      setHasOnboarded(true);
      await AsyncStorage.removeItem('isAuthenticated'); 

    } catch (e) {
      console.log("Error:", e);
    }
  };

  const resetInactivityTimer = () => {
    if (inactivityTimer.current) {
      clearTimeout(inactivityTimer.current);
    }

    inactivityTimer.current = setTimeout(() => {
      handleLogoutFunction();
    }, INACTIVITY_TIMEOUT);
  };

  const handleUserActivity = () => {
    resetInactivityTimer();
  };

  useEffect(() => {
    const checkStatus = async () => {
      const onboarded = await AsyncStorage.getItem('hasOnboarded');
      setHasOnboarded(onboarded === 'true');
      const authenticated = await AsyncStorage.getItem('isAuthenticated');
      const user = await AsyncStorage.getItem('userData');
      if (user !== null) {
        setIsAuthenticated(authenticated === 'true');
      }
      setLoading(false);
      resetInactivityTimer();

    };

    checkStatus();
    const appStateListener = AppState.addEventListener('change', (nextAppState) => {
      if (nextAppState === 'active') {
        resetInactivityTimer();
      }
    });

    return () => {
      if (inactivityTimer.current) {
        clearTimeout(inactivityTimer.current);
      }
      appStateListener.remove(); 
    };
  }, []);

  if (loading) {
    return (
      <Loading/>
    );
  }

  return (
    <TouchableWithoutFeedback onPress={handleUserActivity}> 
    <>
    <NavigationContainer>
      <BalanceProvider>
        {isAuthenticated ? (
          <Tab.Navigator
            screenOptions={({ route }) => ({
              tabBarIcon: ({ focused, color, size }) => {
                let IconComponent: FC<{ width: number; height: number; fill: string }> = () => null;
          
                if (route.name === 'Home') {
                  IconComponent = SvgIcons.Home;
                } else if (route.name === 'History') {
                  IconComponent = SvgIcons.Activity;
                } else if (route.name === 'Account') {
                  IconComponent = SvgIcons.User;
                }
          
                return (
                  <View
                    style={{
                      backgroundColor: focused ? '#ffffff' : 'transparent',
                      borderRadius: focused ? size / 10 : 0,
                      padding: focused ? 5 : 0,
                    }}
                  >
                    <IconComponent width={size} height={size} fill={focused ? '#8f1de9' : color} />
                  </View>
                );
              },
              tabBarLabel: ({ focused, color }) => (
                <Text style={{ color: focused ? '#ffffff' : color, fontSize: 12 }}>
                  {route.name}
                </Text>
              ),
              tabBarActiveTintColor: '#fff',
              tabBarInactiveTintColor: '#fff',
              tabBarStyle: {
                backgroundColor: '#8f1de9',
                borderTopColor: 'transparent',
                height: 80,
                paddingBottom: 20,
              },
              tabBarLabelStyle: {
                fontSize: 10,
              },
            })}
          >
            <Tab.Screen name="Home" component={HomeStack} options={{ headerShown: false, title: 'Home' }} />
            <Tab.Screen name="History" component={HistoryScreen} options={{ headerShown: false }} />
            <Tab.Screen options={{ headerShown: false }} name="Account">
              {(props) => <MoreStack {...props} handleLogoutFunction={handleLogoutFunction} />}
            </Tab.Screen>
          </Tab.Navigator>
        ) : (
          <AuthStack isOnboarded={hasOnboarded} handleLogin={handleLogin} />
        )}
      </BalanceProvider>
      <Toast />
    </NavigationContainer>
    </>
    </TouchableWithoutFeedback>

  );
};

export default App;
