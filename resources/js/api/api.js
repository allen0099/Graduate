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

export const apiPaymentUrlUpdate = (type, url) =>
    Request.post(`/edit_payment_url`, { type, url });

export const apiDepartment = () => Request.get("/department_class");

export const apiClassSetColor = (class_id, color) =>
    Request.post("/department_class", { class_id, color });

export const apiUpdatePdfName = (pdf, value) =>
    Request.post("/update_pdf_name", { pdf, value });

export const apiNewStudent = student =>
    Request.post("/create_new_student", student);

export const apiNewAdmin = admin => Request.post("/create_new_admin", admin);

export const apiResetPassword = id => Request.post("/reset_password", { id });

export const apiAdminList = () => Request.get("/admin_list");

export const apiUpdateUser = (id, name, class_id, payment_check_status, phone) =>
    Request.post("/update_user", { id, name, class_id, payment_check_status, phone });

export const apiPaymentCheckStatus = () => Request.get("/get_payment_check_status");

// Admin Order Actions
export const apiGetOrder = (status, search) =>
    Request.get(`/get_orders?status=${status}&search=${search}`);

export const apiChangePage = (page, status, search) =>
    Request.get(`/get_orders?page=${page}&status=${status}&search=${search}`);

export const apiSearchOrder = search =>
    Request.get(`/search_order?search=${search}`);

export const apiOrderUpdate = (order_id, order) =>
    Request.patch(`/order/${order_id}`, order);

export const apiPaidOrder = (order_id, payment_id) =>
    Request.post("/paid_order", { order_id, payment_id });

export const apiCancelOrder = order_id =>
    Request.post("/cancel_order", { order_id });

export const apiCancelAllUnpaidOrder = check =>
    Request.post("/cancel_all_unpaid_orders", { check });

export const apiReceiveCloth = order_id =>
    Request.post("/receive_order", { order_id });
export const apiReturnCloth = stu_username =>
    Request.post("/return_order", { stu_username });

export const apiNotReturnedTotal = () => Request.get("/not_returned_total");

export const apiEditSet = (set_id, cloth_id, accessory_id) =>
    Request.post("/edit_set", { set_id, cloth_id, accessory_id });

export const apiExportAllOrdersToExcel_path = "/export_all_orders_to_excel";

// Admin Refund
export const apiNoneListedSets = (start_date, end_date) =>
    Request.get(
        `/not_listed_sets?start_date=${start_date}&end_date=${end_date}`
    );

export const apiNewCashierList = (id, start_date, end_date) =>
    Request.post("/new_cashier_list", { id, start_date, end_date });

export const apiUpdateListStatus = (id, status) =>
    Request.post("/update_cashier_list", { id, status });

export const apiGetListByStatus = status_code =>
    Request.get(`/cashier_list?status_code=${status_code}`);

export const apiLockList = id => Request.post(`/lock_list`, { id });

// export const apiRefundPdf = id => Request.get(`/refund_pdf?id=${id}`);

// Admin pdf
export const apiPreservePdf = () => Request.get("/preserve_pdf");
export const apiPreserveAllPdf = () => Request.get("/preserve_all_pdf");
export const apiNonePreservePdf = () => Request.get("/none_preserve_pdf");
export const apiGetAllPreservePdf = () => Request.get("/get_all_preserve_pdf");

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
export const apiUploadPayments = csv_file =>
    UploadRequest.post("/upload_payments", csv_file);
export const apiUploadPaymentCheckStatus = csv_file =>
    UploadRequest.post("/upload_payment_check_status", csv_file);

export const apiCheckPdfExist = filename =>
    Request.get(`find_pdf?name=${filename}`);
/******** Student ********/

// Student order
export const apiSearchOwner = () => Request.get(`/order_owner`);
export const apiSearchStudent = username =>
    Request.get(`/search_user?search=${username}`);
export const apiCreateOrder = order => Request.post("/order", order);

// Student myorder
export const apiPreserveDate = (order_id, preserve_date) =>
    Request.post("/preserve_order", { order_id, preserve_date });

export const apiTrashedOrders = () => Request.get("/trashed_orders");
