import axios from "axios";

const baseURL = "/";

const Request = axios.create({
    baseURL: baseURL,
    withCredentials: true
});

// Admin Setting - inventory
export const apiInventoryUpdate = (id, res) =>
    Request.patch(`/item/${id}`, res);

export const apiRoomAirQualityValue = (room_id, obj_name) =>
    Request.get(`/room/${room_id}/${obj_name}/last`);

export const apiRoomAirQualityChart = (room_id, obj_name) =>
    Request.get(`/room/${room_id}/${obj_name}/range`);

export const apiRoomAlter = room_id => Request.get(`/room/${room_id}/alert`);

export const apiRoomConTrolDevice = room_id =>
    Request.get(`/room/${room_id}/controldevice`);
