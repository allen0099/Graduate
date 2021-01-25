import axios from "axios";

const baseURL = "/";

const Request = axios.create({
    baseURL: baseURL,
    withCredentials: true
});

// Admin Setting
export const apiInventoryUpdate = (id, res) =>
    Request.patch(`/item/${id}`, res);

// Admin order
export const apiOrderUpdate = (order_id, order) =>
    Request.patch(`/order/${order_id}`, order);

// Admin Return & Receive
export const apiSearchOrder = search =>
    Request.get(`/search_order?search=${search}`);

// Student oreder
export const apiSearchStudent = stu_id =>
    Request.get(`/search_user?search=${stu_id}`);

export const apiCreateOrder = order => Request.post("/order", order);
