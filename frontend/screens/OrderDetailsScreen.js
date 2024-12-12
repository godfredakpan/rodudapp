import React, { useRef } from 'react';
import { View, Text, StyleSheet, TouchableOpacity, Clipboard } from 'react-native';
import { captureRef } from 'react-native-view-shot';
import Share from 'react-native-share';
import { useRoute } from '@react-navigation/native';
import { formatDate } from '../elements/common';
import Toast from 'react-native-toast-message';

const OrderDetailsScreen = () => {
  const route = useRoute();
  const { order } = route.params;
  const viewRef = useRef();

  const handleShareReceipt = async () => {
    try {
      const uri = await captureRef(viewRef, {
        format: 'png',
        quality: 0.8,
      });

      await Share.open({
        url: uri,
        type: 'image/png',
        title: 'Share Order Receipt',
        message: 'Here is the receipt for the order',
      });
    } catch (error) {
      console.log('Error sharing receipt:', error);
    }
  };

  const handleCopyToClipboard = (string) => {
    Clipboard.setString(string);
    console.log('Copied to clipboard:', string);
    Toast.show({ type: 'success', text1: 'Success', text2: 'Copied to clipboard', position: 'bottom' });
  };

  if (!order) {
    return null; 
  }

  return (
    <View style={styles.container}>
      
      <View style={styles.header}>
        <TouchableOpacity style={styles.shareButton} onPress={handleShareReceipt}>
          <Text style={{color: '#ffffff'}}>Share</Text>
        </TouchableOpacity>
      </View>
      <View style={styles.receiptContainer} ref={viewRef}>
        <Text style={styles.title}>Truck Order Details</Text>
        <View style={styles.detailRow}>
          <Text style={styles.label}>Pickup Location:</Text>
          <Text style={styles.value}>{order.pickup_location}</Text>
        </View>
        <View style={styles.detailRow}>
          <Text style={styles.label}>Delivery Location:</Text>
          <Text style={styles.value}>{order.delivery_location}</Text>
        </View>
        <View style={styles.detailRow}>
          <Text style={styles.label}>Pickup Time:</Text>
          <Text style={styles.value}>{formatDate(order.pickup_time)}</Text>
        </View>
        <View style={styles.detailRow}>
          <Text style={styles.label}>Delivery Time:</Text>
          <Text style={styles.value}>{formatDate(order.delivery_time)}</Text>
        </View>
        <View style={styles.detailRow}>
          <Text style={styles.label}>Truck Size:</Text>
          <Text style={styles.value}>{order.truck_size}</Text>
        </View>
        <View style={styles.detailRow}>
          <Text style={styles.label}>Weight:</Text>
          <Text style={styles.value}>{order.weight} kg</Text>
        </View>
        <View style={styles.detailRow}>
          <Text style={styles.label}>Status:</Text>
          <Text style={styles.value}>{order.status}</Text>
        </View>
        <View style={styles.detailRow}>
          <Text style={styles.label}>Order Reference:</Text>
          <Text onPress={() => handleCopyToClipboard(order.order_reference)} style={styles.value}>
            {order.order_reference}
          </Text>
        </View>
      </View>
      <View style={styles.footer}>
        <Text style={styles.footerText}>Rodudapp</Text>
        <View style={styles.zigzag} />
        <Text style={styles.footerText}>© {new Date().getFullYear()}</Text>
      </View>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#f3f6ff',
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'flex-end',
    marginBottom: 20,
  },
  receiptContainer: {
    backgroundColor: '#fff',
    padding: 20,
    borderRadius: 15,
    elevation: 2,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 5,
  },
  title: {
    fontSize: 22,
    fontWeight: 'bold',
    color: '#000000',
    marginBottom: 20,
    textAlign: 'center',
  },
  detailRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 10,
  },
  label: {
    fontSize: 16,
    fontWeight: '600',
    color: '#666',
  },
  value: {
    fontSize: 16,
    flexWrap: 'wrap',
    flex: 1,
    textAlign: 'right',
    fontWeight: '400',
    color: '#000000',
  },
  shareButton: {
    backgroundColor: '#007aff',
    paddingVertical: 10,
    paddingHorizontal: 15,
    borderRadius: 20,
    elevation: 3,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 1 },
    shadowOpacity: 0.2,
    shadowRadius: 2,
  },
  footer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: 10,
    borderTopWidth: 1,
    borderTopColor: '#ddd',
  },
  footerText: {
    fontSize: 15,
  },
  zigzag: {
    borderTopWidth: 1,
    borderTopColor: '#ddd',
    borderLeftWidth: 1,
    borderLeftColor: 'transparent',
    width: 50,
    height: 20,
  },
});

export default OrderDetailsScreen;
