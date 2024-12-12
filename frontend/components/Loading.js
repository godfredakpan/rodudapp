import React, { useEffect, useRef } from 'react';
import { View, Text, Animated, StyleSheet } from 'react-native';

const Loading = () => {
  const truckPosition = useRef(new Animated.Value(0)).current;

  useEffect(() => {
    Animated.loop(
      Animated.sequence([
        Animated.timing(truckPosition, {
          toValue: 300, 
          duration: 2000,
          useNativeDriver: true,
        }),
        Animated.timing(truckPosition, {
          toValue: 0,
          duration: 0, 
          useNativeDriver: true,
        }),
      ])
    ).start();
  }, [truckPosition]);

  return (
    <View style={styles.container}>
      <Animated.Image
        source={require('../assets/truck.png')}
        style={[styles.truck, { transform: [{ translateX: truckPosition }] }]}
      />
      <Text style={styles.text}>Please wait, our truck is coming to you.</Text>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f3f6ff',
    padding: 20,
  },
  truck: {
    width: 150,
    height: 100,
    marginBottom: 20,
    resizeMode: 'contain',
  },
  text: {
    marginTop: 10,
    fontSize: 16,
    color: '#333',
    fontWeight: '500',
  },
});

export default Loading;
