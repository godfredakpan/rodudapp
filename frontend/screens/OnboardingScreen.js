import React from 'react';
import { View, Text, Image, StyleSheet } from 'react-native';
import AppIntroSlider from 'react-native-app-intro-slider';
import AsyncStorage from '@react-native-async-storage/async-storage';

const slides = [
  {
    key: 'one',
    title: 'Welcome to Rodud',
    text: 'The app that connects you with your best transport.',
    image: require('../assets/slide1.png'), 
    backgroundColor: '#8f1de9',
  },
  {
    key: 'two',
    title: 'Stay Empowered',
    text: 'Let us power your freight logistics processes with ease.',
    image: require('../assets/slide2.png'), 
    backgroundColor: '#C28C0E',
  },
];

const OnboardingScreen = ({ navigation }) => {
  const _renderItem = ({ item }) => {
    return (
      <View style={[styles.slide, { backgroundColor: item.backgroundColor }]}>
        <Text style={styles.title}>{item.title}</Text>
        <Image source={item.image} style={styles.image} />
        {/* <Text style={styles.text}>{item.text}</Text> */}
      </View>
    );
  };

  const _onDone = async () => {
    await AsyncStorage.setItem('hasOnboarded', 'true');
    navigation.replace('Login'); 
  };

  return <AppIntroSlider renderItem={_renderItem} data={slides} onDone={_onDone} />;
};

const styles = StyleSheet.create({
  slide: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#fff',
    textAlign: 'center',
    marginBottom: 20,
  },
  image: {
    width: 200,
    height: 200,
    marginBottom: 20,
  },
  text: {
    fontSize: 16,
    color: '#fff',
    textAlign: 'center',
    paddingHorizontal: 16,
  },
});

export default OnboardingScreen;
