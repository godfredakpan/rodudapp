import React from 'react';
import { View, Text, TouchableOpacity, Linking, StyleSheet } from 'react-native';
import SvgIcons from '../elements/SvgIcons';


const SupportScreen = () => {
  const handleEmailPress = () => Linking.openURL('mailto:godfredakpan@gmail.com');
  const handlePhonePress = () => Linking.openURL('tel:+2349036709916');
  const handleSocialPress = (url) => Linking.openURL(url);

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Support</Text>
      <Text style={styles.description}>
        For any questions or support, please contact us through the following channels:
      </Text>

      <TouchableOpacity style={styles.infoContainer} onPress={handleEmailPress}>
        <SvgIcons.Email width={24} height={24} fill="#0051ba" />
        <Text style={styles.infoText}>godfredakpan@gmail.com</Text>
      </TouchableOpacity>

      <TouchableOpacity style={styles.infoContainer} onPress={handlePhonePress}>
        <SvgIcons.Phone width={24} height={24} fill="#0051ba" />
        <Text style={styles.infoText}>+2349036709916</Text>
      </TouchableOpacity>

      <View style={styles.socialContainer}>
        <Text style={styles.socialTitle}>Follow us on:</Text>
        <View style={styles.socialIcons}>
          <TouchableOpacity onPress={() => handleSocialPress('https://x.com/rodudapp')}>
            <Text style={styles.handle}>X-Twitter</Text>
          </TouchableOpacity>
          <TouchableOpacity onPress={() => handleSocialPress('https://instagram.com/rodudapp')}>
          <Text style={styles.handle}>Instagram</Text>
          </TouchableOpacity>
        </View>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 16,
    backgroundColor: '#f0f4ff',
    justifyContent: 'center',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#8f1de9',
    marginBottom: 24,
    textAlign: 'center',
  },
  description: {
    fontSize: 16,
    marginBottom: 16,
    textAlign: 'center',
    color: '#555',
  },
  infoContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: 12,
    backgroundColor: '#ffff',
    borderRadius: 8,
    marginVertical: 8,
  },
  infoText: {
    marginLeft: 12,
    fontSize: 16,
    color: '#8f1de9',
  },
  socialContainer: {
    marginTop: 32,
    alignItems: 'center',
  },
  socialTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    color: '#8f1de9',
    marginBottom: 16,
  },
  socialIcons: {
    flexDirection: 'row',
  },
  socialIcon: {
    marginHorizontal: 16,
  },
  handle:{
    color: '#8f1de9',
    margin: 10
  }
});

export default SupportScreen;
