import axios from "axios";

const baseURL = "/";

const Request = axios.create({
    baseURL: baseURL,
    withCredentials: true
});

// Admin Setting
export const apiInventoryUpdate = (id, res) =>
    Request.patch(`/item/${id}`, res);

export const apiPriceUpdate = (cloth, price) =>
    Request.post(`/edit_set_price`, { cloth, price });

// Admin order
export const apiOrderUpdate = (order_id, order) =>
    Request.patch(`/order/${order_id}`, order);

// Admin Return & Receive
export const apiSearchOrder = search =>
    Request.get(`/search_order?search=${search}`);
export const apiReturnCloth = stu_id =>
    Request.get(`/return_order?stu_id=${stu_id}`);

// Student oreder
export const apiSearchStudent = stu_id =>
    Request.get(`/search_user?search=${stu_id}`);

export const apiCreateOrder = order => Request.post("/order", order);
