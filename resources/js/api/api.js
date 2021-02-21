import axios from "axios";

const baseURL = "/";

const Request = axios.create({
    baseURL: baseURL,
    withCredentials: true
});

const UploadRequest = axios.create({
    baseURL: baseURL,
    withCredentials: true,
    headers: {
        "Content-Type": "multipart/form-data"
    }
});

/******** Admin ********/

// Admin Setting
export const apiInventoryUpdate = (id, res) =>
    Request.patch(`/item/${id}`, res);

export const apiPriceUpdate = (type, price) =>
    Request.post(`/edit_price`, { type, price });

export const apiDepartment = () => Request.get("/department_class");

export const apiClassSetColor = (class_id, color) =>
    Request.post("/department_class", { class_id, color });

// Admin Order Actions
export const apiSearchOrder = search =>
    Request.get(`/search_order?search=${search}`);

export const apiOrderUpdate = (order_id, order) =>
    Request.patch(`/order/${order_id}`, order);

export const apiCancelOrder = order_id =>
    Request.post("/cancel_order", { order_id });

export const apiReceiveCloth = order_id =>
    Request.post("/receive_order", { order_id });
export const apiReturnCloth = stu_username =>
    Request.post("/return_order", { stu_username });
export const apiRefundCloth = stu_username =>
    Request.post("/refund_order", { stu_username });

export const apiNotReturnedTotal = () => Request.get("/not_returned_total");

// Admin Refund
export const apiNoneListedSets = (start_date, end_date) =>
    Request.get(
        `/not_listed_sets?start_date=${start_date}&end_date=${end_date}`
    );

export const apiNewCashierList = id =>
    Request.post("/new_cashier_list", { id });

export const apiUpdateListStatus = (id, status) =>
    Request.post("/update_cashier_list", { id, status });

export const apiGetListByStatus = status_code =>
    Request.get(`/cashier_list?status_code=${status_code}`);

// export const apiRefundPdf = id => Request.get(`/refund_pdf?id=${id}`);

// Admin pdf
export const apiPreservePdf = () => Request.get("/preserve_pdf");

// Admin Upload
export const apiUploadFile = file => UploadRequest.post("/test_upload", file);
export const apiUpdateStamp = image =>
    UploadRequest.post("/admin_stamp", image);
export const apiUpdateDepartmentStamp = image =>
    UploadRequest.post("/department_stamp", image);
export const apiUploadStudent = csv_file =>
    UploadRequest.post("/upload_student", csv_file);
export const apiUploadPdf = pdf_file =>
    UploadRequest.post("/upload_pdf", pdf_file);
export const apiCheckExist = filepath => Request.get(`${filepath}`);

/******** Student ********/

// Student order
export const apiSearchOwner = () => Request.get(`/order_owner`);
export const apiSearchStudent = stu_id =>
    Request.get(`/search_user?search=${stu_id}`);
export const apiCreateOrder = order => Request.post("/order", order);

// Student myorder
export const apiPreserveDate = (order_id, preserve_date) =>
    Request.post("/preserve_order", { order_id, preserve_date });

export const apiTrashedOrders = () => Request.get("/trashed_orders");
