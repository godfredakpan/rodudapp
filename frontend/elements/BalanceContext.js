import React, { createContext, useState, useEffect } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';

export const BalanceContext = createContext();

// This will be introduced in a later version when the users have a wallet system :: Godfred
export const BalanceProvider = ({ children }) => {
  const [hideBalance, setHideBalance] = useState(false);

  useEffect(() => {
    const getHideBalance = async () => {
      const storedHideBalance = await AsyncStorage.getItem('hideBalance');
      if (storedHideBalance !== null) {
        setHideBalance(JSON.parse(storedHideBalance));
      }
    };
    getHideBalance();
  }, []);

  const toggleBalance = async () => {
    const newHideBalance = !hideBalance;
    setHideBalance(newHideBalance);
    await AsyncStorage.setItem('hideBalance', JSON.stringify(newHideBalance));
  };

  return (
    <BalanceContext.Provider value={{ hideBalance, toggleBalance }}>
      {children}
    </BalanceContext.Provider>
  );
};
