import React, { useState } from "react";
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  TextInput,
  Modal,
} from "react-native";
import DateTimePicker from "@react-native-community/datetimepicker";
import { createTruckRequest } from "../elements/api/orders";
import Loading from "./Loading";
import moment from "moment";

const RequestOrder = () => {
  const [showForm, setShowForm] = useState(false);
  const [formData, setFormData] = useState({
    pickup_location: "",
    delivery_location: "",
    truck_size: "",
    weight: "",
    pickup_time: new Date(),
    delivery_time: new Date(),
  });
  const [showPickupPicker, setShowPickupPicker] = useState(false);
  const [showDeliveryPicker, setShowDeliveryPicker] = useState(false);
  const [loading, setLoading] = useState(false);

  const handleInputChange = (field, value) => {
    setFormData({ ...formData, [field]: value });
  };

  const handleDateChange = (event, selectedDate, field) => {
    setFormData({ ...formData, [field]: selectedDate });
  };

  const handleSubmit = async () => {
    const {
      pickup_location,
      delivery_location,
      pickup_time,
      delivery_time,
      truck_size,
      weight,
    } = formData;

    if (!pickup_location.trim()) {
      alert("Pickup location is required.");
      return;
    }

    if (!truck_size || !weight) {
      alert("Truck size and weight are required.");
      return;
    }

    if (!delivery_location.trim()) {
      alert("Delivery location is required.");
      return;
    }

    if (pickup_location.trim() === delivery_location.trim()) {
      alert("Pickup and delivery locations cannot be the same.");
      return;
    }

    console.log("formattedPickupTime1", formattedPickupTime)
    console.log("data2", formattedDeliveryTime)

    const currentDate = moment();

    const pickupTime = moment(pickup_time);

    if (pickupTime.isBefore(currentDate)) {
      alert('Pickup time cannot be in the past. Please select a valid time.');
      return; 
    }

    const formattedPickupTime = moment(pickup_time).format('YYYY-MM-DD HH:mm:ss');

    const formattedDeliveryTime = moment(delivery_time).format('YYYY-MM-DD HH:mm:ss');

    if (formattedPickupTime >= formattedDeliveryTime) {
      alert("Pickup time cannot be later than or equal to delivery time.");
      return;
    }

    try {
      setLoading(true);

      const body = {
        pickup_location,
        delivery_location,
        pickup_time: formattedPickupTime,
        delivery_time: formattedDeliveryTime,
        truck_size,
        weight,
        status: "pending",
        order_reference: Math.random().toString(36).substring(7),
      };

      // Create the truck request
      const create = await createTruckRequest(body);
      console.log("crewt", create);
      if (create.success) {
        alert("Success", "Truck request submitted successfully");
        // setFormData({
        //   pickup_location: "",
        //   delivery_location: "",
        //   truck_size: "",
        //   weight: "",
        // });
        return;
      } else {
        throw new Error("Failed to submit truck request, please try again");
      }
    } catch (error) {
      console.error(error);
      alert("error", "An error occurred, please try again");
    } finally {
      setLoading(false);
    }
  };

  if(loading) {
    return (
      <Loading/>
    );
  }

  return (
    <View style={styles.container}>
      <TouchableOpacity style={styles.item} onPress={() => setShowForm(true)}>
        <Text style={styles.text}>Request Truck</Text>
      </TouchableOpacity>

      <Modal
        visible={showForm}
        transparent={true}
        animationType="fade"
        onRequestClose={() => setShowForm(false)}
      >
        <View style={styles.modalOverlay}>
          <View style={styles.formContainer}>
            <Text style={styles.formHeader}>Truck Delivery Form</Text>

            <TextInput
              style={styles.input}
              placeholder="Pickup Location"
              placeholderTextColor={"#000000"}
              value={formData.pickup_location}
              onChangeText={(value) =>
                handleInputChange("pickup_location", value)
              }
            />
            <TextInput
              style={styles.input}
              placeholder="Delivery Location"
              placeholderTextColor={"#000000"}
              value={formData.delivery_location}
              onChangeText={(value) =>
                handleInputChange("delivery_location", value)
              }
            />
            <TextInput
              style={styles.input}
              placeholder="Truck Size"
              placeholderTextColor={"#000000"}
              value={formData.truck_size}
              onChangeText={(value) => handleInputChange("truck_size", value)}
            />
            <TextInput
              style={styles.input}
              placeholder="Weight (in kg)"
              placeholderTextColor={"#000000"}
              value={formData.weight.toString()}
              keyboardType="numeric"
              onChangeText={(value) => handleInputChange("weight", value)}
            />

            <TouchableOpacity
              style={styles.datePickerButton}
              onPress={() => setShowPickupPicker(!showPickupPicker)}
            >
              <Text style={styles.datePickerText}>Select Pickup Time</Text>
            </TouchableOpacity>
            {showPickupPicker && (
              <DateTimePicker
                value={formData.pickup_time}
                mode="datetime"
                style={styles.datepicker}
                display="default"
                onChange={(event, selectedDate) =>
                  handleDateChange(event, selectedDate, "pickup_time")
                }
              />
            )}

            <TouchableOpacity
              style={styles.datePickerButton}
              onPress={() => setShowDeliveryPicker(!showDeliveryPicker)}
            >
              <Text style={styles.datePickerText}>Select Delivery Time</Text>
            </TouchableOpacity>
            {showDeliveryPicker && (
              <DateTimePicker
                value={formData.delivery_time}
                mode="datetime"
                style={styles.datepicker}
                display="default"
                onChange={(event, selectedDate) =>
                  handleDateChange(event, selectedDate, "delivery_time")
                }
              />
            )}

            <View style={styles.buttonContainer}>
              <TouchableOpacity
                style={styles.submitButton}
                onPress={handleSubmit}
              >
                <Text style={styles.submitButtonText}>Submit</Text>
              </TouchableOpacity>
              <TouchableOpacity
                style={[styles.submitButton, styles.closeButton]}
                onPress={() => setShowForm(false)}
              >
                <Text style={styles.submitButtonText}>Close</Text>
              </TouchableOpacity>
            </View>
          </View>
        </View>
      </Modal>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    padding: 16,
  },
  item: {
    width: "100%",
    backgroundColor: "#7c18cc",
    borderRadius: 12,
    paddingVertical: 16,
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "center",
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.2,
    shadowRadius: 4,
    elevation: 5,
  },
  iconContainer: {
    marginRight: 10,
  },
  icon: {
    color: "#fff",
  },
  text: {
    fontSize: 18,
    color: "#fff",
    fontWeight: "600",
  },
  modalOverlay: {
    flex: 1,
    backgroundColor: "rgba(0, 0, 0, 0.5)",
    justifyContent: "center",
    alignItems: "center",
  },
  formContainer: {
    backgroundColor: "#fff",
    borderRadius: 16,
    padding: 20,
    width: "90%",
    shadowColor: "#000",
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.1,
    shadowRadius: 10,
    elevation: 10,
  },
  formHeader: {
    fontSize: 20,
    fontWeight: "bold",
    marginBottom: 16,
    textAlign: "center",
    color: "#000",
  },
  input: {
    height: 48,
    borderRadius: 8,
    marginBottom: 12,
    paddingHorizontal: 12,
    fontSize: 16,
    backgroundColor: "#F3F4F6",
  },
  datePickerButton: {
    marginBottom: 12,
    padding: 12,
    backgroundColor: "#F3F4F6",
    borderRadius: 8,
    alignItems: "center",
  },
  datePickerText: {
    fontSize: 16,
    color: "#6C757D",
  },
  datepicker: {
    marginBottom: 10,
  },
  buttonContainer: {
    flexDirection: "row",
    justifyContent: "space-between",
    marginTop: 20,
  },
  submitButton: {
    backgroundColor: "#7c18cc",
    paddingVertical: 12,
    paddingHorizontal: 20,
    borderRadius: 8,
    width: "45%",
    alignItems: "center",
  },
  closeButton: {
    backgroundColor: "lightgrey",
  },
  submitButtonText: {
    fontSize: 16,
    color: "#fff",
    fontWeight: "600",
  },
});
export default RequestOrder;
