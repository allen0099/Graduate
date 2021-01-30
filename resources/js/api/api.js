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

// Admin Order Actions
export const apiSearchOrder = search =>
    Request.get(`/search_order?search=${search}`);

export const apiOrderUpdate = (order_id, order) =>
    Request.patch(`/order/${order_id}`, order);

export const apiCancelOrder = order_id =>
    Request.post("/cancel_order", { order_id });

// export const apiPaidOrder = order_id => Request.post("/paid_order", order_id);
export const apiReceiveCloth = order_id =>
    Request.post("/receive_order", { order_id });
export const apiReturnCloth = stu_username =>
    Request.post("/return_order", { stu_username });
export const apiRefundCloth = stu_username =>
    Request.post("/refund_order", { stu_username });

// Student order
export const apiSearchOwner = () => Request.get(`/order_owner`);
export const apiSearchStudent = stu_id =>
    Request.get(`/search_user?search=${stu_id}`);
export const apiCreateOrder = order => Request.post("/order", order);
