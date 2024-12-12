import React, {useState, useCallback} from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  ScrollView,
  TextInput,
  Image,
} from 'react-native';

import AsyncStorage from '@react-native-async-storage/async-storage';
import {formatDate} from '../elements/common';
import {useFocusEffect} from '@react-navigation/native';
import Loading from '../components/Loading';
import { getUserOrders } from '../elements/api/orders';

const HistoryScreen = ({navigation}) => {
  const [truckRequests, setTruckRequests] = useState([]);
  const [loading, setLoading] = useState(false);
  const [searchQuery, setSearchQuery] = useState('');

  useFocusEffect(
    useCallback(() => {
      const fetchData = async () => {
        try {
          setLoading(true);
          const token = await AsyncStorage.getItem('isAuthenticated');
          if (!token) {
            navigation.navigate('Login');
          } else {
            const requestsData = await getUserOrders();
            console.log('requestsData', requestsData);
            if (!requestsData) {
              setLoading(false);
              return;
            }
            requestsData.sort(
              (a, b) => new Date(b.created_at) - new Date(a.created_at),
            );
            setTruckRequests(requestsData);
            setLoading(false);
          }
        } catch (error) {
          console.log('Error fetching data: ', error);
        }
      };

      fetchData();
    }, [navigation])
  );

  const getStatusColor = (status) => {
    switch (status) {
      case 'delivered':
        return '#74BD4B';
      case 'pending':
        return '#DC486F';
      case 'in progress':
        return '#F7B24D';
      default:
        return 'black';
    }
  };

  const filteredRequests = truckRequests.filter((request) =>
    request.pickup_location.toLowerCase().includes(searchQuery.toLowerCase()) ||
    request.delivery_location.toLowerCase().includes(searchQuery.toLowerCase())
  );

  const handlePress = (order) => {
    navigation.navigate('OrderDetails', { order });
  };

  if (loading) {
    return (
      <Loading/>
    );
  }

  return (
    <View style={styles.container}>
      {truckRequests.length > 0 && (
        <View style={styles.searchContainer}>
          <TextInput
            style={styles.searchInput}
            placeholder="Search truck requests..."
            placeholderTextColor={'#000000'}
            onChangeText={text => setSearchQuery(text)}
            value={searchQuery}
          />
        </View>
      )}
      <ScrollView style={styles.body}>
        {filteredRequests.length > 0 ? (
          filteredRequests.map((order, index) => (
            <React.Fragment key={index}>
              <TouchableOpacity onPress={() => handlePress(order)}>
                <View style={styles.requestRow}>
                  <View style={styles.info}>
                    <Text style={styles.requestName}>
                      Pickup from {order.pickup_location} to {order.delivery_location}
                    </Text>
                    <Text style={styles.requestDate}>
                      {formatDate(order.created_at)}
                    </Text>
                  </View>
                  <View style={styles.statusContainer}>
                    <View
                      style={[
                        styles.statusBadge,
                        {backgroundColor: getStatusColor(order.status)},
                      ]}>
                      <Text style={styles.statusText}>
                        {order.status}
                      </Text>
                    </View>
                  </View>
                </View>
              </TouchableOpacity>
              <View style={styles.separator} />
            </React.Fragment>
          ))
        ) : (
          <View style={styles.emptyState}>
            <Image
              source={{
                uri: 'https://static.vecteezy.com/system/resources/previews/011/537/764/non_2x/find-folder-empty-state-single-isolated-icon-with-flat-style-free-vector.jpg',
              }}
              style={styles.notFoundIcon}
            />
            <Text style={styles.emptyStateText}>No truck requests found</Text>
          </View>
        )}
      </ScrollView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingTop: 50,
    backgroundColor: '#fff',
  },
  searchContainer: {
    paddingHorizontal: 16,
    paddingBottom: 16,
    paddingTop: 16,
    backgroundColor: 'white',
    borderBottomWidth: 1,
    borderBottomColor: '#ccc',
    zIndex: 1,
    position: 'sticky',
    top: 0,
  },
  searchInput: {
    borderWidth: 1,
    color: '#8f1de9',
    borderColor: '#ccc',
    borderRadius: 5,
    padding: 10,
  },
  body: {
    flex: 1,
  },
  requestRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingHorizontal: 16,
    paddingVertical: 10,
  },
  separator: {
    backgroundColor: '#f8eefe',
    height: 1,
  },
  info: {
    flex: 1,
    marginRight: 12,
  },
  requestName: {
    fontSize: 15,
    fontWeight: '500',
  },
  requestDate: {
    fontSize: 15,
    color: '#888',
  },
  statusContainer: {
    alignItems: 'flex-end',
  },
  statusBadge: {
    marginTop: 4,
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 5,
  },
  statusText: {
    fontSize: 10,
    color: '#fff',
    textTransform: 'capitalize',
  },
  notFoundIcon: {
    width: 200,
    height: 200,
    resizeMode: 'contain',
    marginBottom: 16,
  },
  emptyState: {
    alignItems: 'center',
    justifyContent: 'center',
    padding: 16,
  },
  emptyStateText: {
    fontSize: 12,
    fontWeight: '400',
    color: '#888',
  },
});

export default HistoryScreen;
