import request from "umi-request";
import { API_URL, getToken } from "../config";

export async function getUserOrders() {
  return request(`${API_URL}/orders/user`, {
    method: "get",
    headers: {
      "Content-Type": "application/json",
      Authorization: await getToken(),
    },
  });
}

export async function createTruckRequest(body) {
  try {
    const response = await request(`${API_URL}/orders/create`, {
      method: "post",
      headers: {
        "Content-Type": "application/json",
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Headers": "*",
        Authorization: await getToken(),
      },
      body: JSON.stringify(body),
    });

    return response;
  } catch (error) {
    console.log("An error occurred while creating the order:", error);
  }
}
