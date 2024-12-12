import React, { useRef, useEffect, useState, useCallback } from "react";
import {
  View,
  Text,
  StyleSheet,
  Animated,
  Dimensions,
  ScrollView,
  Image,
  TouchableOpacity,
} from "react-native";
import { getUserOrders } from "../elements/api/orders";
import { formatDate } from "../elements/common";
import { useFocusEffect, useNavigation } from "@react-navigation/native";
import Loading from "./Loading";

const SlidingNews = () => {
  const screenWidth = Dimensions.get("window").width;
  const translateX = useRef(new Animated.Value(screenWidth)).current;

  const newsItems = [
    "🚚 New feature: Live tracking is now available!",
    "📦 Tip: Ensure accurate pickup addresses for faster deliveries.",
    "🔔 Stay updated: Enable notifications for shipment alerts!",
  ];

  useEffect(() => {
    Animated.loop(
      Animated.sequence([
        Animated.timing(translateX, {
          toValue: -screenWidth,
          duration: 6000,
          useNativeDriver: true,
        }),
        Animated.timing(translateX, {
          toValue: 0,
          duration: 0,
          useNativeDriver: true,
        }),
      ])
    ).start();
  }, []);


  return (
    <View style={styles.newsContainer}>
      <Animated.View
        style={[
          styles.newsSlider,
          {
            transform: [{ translateX }],
          },
        ]}
      >
        {newsItems.map((item, index) => (
          <View key={index} style={[styles.newsItem, { width: screenWidth }]}>
            <Text style={styles.newsText}>{item}</Text>
          </View>
        ))}
      </Animated.View>
    </View>
  );
};

const Updates = () => {
  const navigation = useNavigation();

  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(false);
  const handlePress = (order) => {
    navigation.navigate('OrderDetails', { order });
  };

  useFocusEffect(
    useCallback(() => {
      const fetchData = async () => {
        try {
          setLoading(true);
            const orders = await getUserOrders();
            orders.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
            orders.splice(2); 
            setOrders(orders);
            setLoading(false);
        } catch (error) {
          console.log('Error fetching data: ', error);
        }
      };

      fetchData();
    }, [navigation])
  );

  if (loading) {
    return (
      <Loading/>
    );
  }

  return (
    <ScrollView style={styles.container}>
      <View style={styles.headerContainer}>
        <Image
          source={require("../assets/footerLogo.png")}
          style={styles.logo}
        />
      </View>

      {/* Sliding News Section */}
      <View style={styles.sectionContainer}>
        <Text style={styles.sectionHeader}>📢 Latest Updates</Text>
        <SlidingNews />
      </View>

      {/* Recent Orders Section */}
      <View style={styles.sectionContainer}>
        <Text style={styles.sectionHeader}>🛒 Recent Orders</Text>
        {orders && orders.length > 0 ? (
          orders.map((order, index) => (
            <React.Fragment key={index}>
              <TouchableOpacity onPress={() => handlePress(order)}>
                <View key={index} style={styles.card}>
                  <Text style={styles.cardTitle}>Order #{order.id}</Text>
                  <Text style={styles.cardText}>
                    Pickup: {order.pickup_location}
                  </Text>
                  <Text style={styles.cardText}>
                    Delivery: {order.delivery_location}
                  </Text>
                  <Text style={styles.cardStatus}>Status: {order.status}</Text>
                  <Text style={styles.cardText}>
                    Date: {formatDate(order.created_at)}
                  </Text>
                </View>
              </TouchableOpacity>
            </React.Fragment>
          ))
        ) : (
          <View style={styles.emptyState}>
            <Image
              source={{
                uri: "https://static.vecteezy.com/system/resources/previews/011/537/764/non_2x/find-folder-empty-state-single-isolated-icon-with-flat-style-free-vector.jpg",
              }}
              style={styles.notFoundIcon}
            />
            <Text style={styles.emptyStateText}>No Orders yet</Text>
          </View>
        )}
      </View>
    </ScrollView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#f9f9f9",
    paddingHorizontal: 20,
  },
  headerContainer: {
    marginTop: 20,
    backgroundColor: "#000000",
    alignItems: "center",
  },
  welcomeText: {
    fontSize: 24,
    fontWeight: "bold",
    color: "#8f1de9",
  },
  logo: {
    width: 120,
    height: 120,
    resizeMode: "contain",
    alignSelf: "center",
  },
  subtitle: {
    fontSize: 16,
    color: "#6C757D",
    marginTop: 8,
  },
  sectionContainer: {
    marginTop: 30,
  },
  sectionHeader: {
    fontSize: 18,
    fontWeight: "600",
    color: "#8f1de9",
    marginBottom: 10,
  },
  newsContainer: {
    height: 50,
    backgroundColor: "#f8eefe",
    borderRadius: 10,
    overflow: "hidden",
    justifyContent: "center",
  },
  newsSlider: {
    flexDirection: "row",
  },
  newsItem: {
    justifyContent: "center",
    alignItems: "center",
  },
  newsText: {
    fontSize: 14,
    fontWeight: "500",
    color: "#8f1de9",
    textAlign: "center",
  },
  card: {
    backgroundColor: "#ffffff",
    borderRadius: 10,
    padding: 16,
    marginBottom: 15,
    shadowColor: "#000",
    shadowOpacity: 0.1,
    shadowOffset: { width: 0, height: 4 },
    shadowRadius: 6,
    elevation: 2,
  },
  cardTitle: {
    fontSize: 16,
    fontWeight: "bold",
    color: "#343A40",
    marginBottom: 5,
  },
  cardText: {
    fontSize: 14,
    color: "#495057",
    marginBottom: 5,
  },
  cardStatus: {
    fontSize: 14,
    color: "#28A745",
    fontWeight: "600",
  },
});

export default Updates;
