export const created = 1; // 訂單成立 尚未繳費
export const paid = 2; // 完成繳費 尚未領取衣服
export const received = 3; // 完成領取衣服 尚未歸還衣服
export const returned = 4; // 完成歸還衣服 完成歸還保證金
export const refunded = 5; // 已還款
export const canceled = 6; // 已取消訂單

export const Status = {
    created,
    paid,
    received,
    returned,
    refunded,
    canceled
};

export const Refond_code = {
    init: 1, // 批次建立
    progress: 2, // 送出納組
    finished: 3 // 完成還款
};

export const StatusMsg = [
    "Owo",
    "未付款",
    "已付款，未領取衣服",
    "未歸還衣服",
    "已歸還衣服",
    "已還款",
    "已取消"
];

export const colorList = [
    {
        bg: "#fef9ef",
        detail: "#d48344"
    },
    {
        bg: "#fef9ef",
        detail: "#d48344"
    },
    {
        bg: "#fef9ef",
        detail: "#d48344"
    },
    {
        bg: "#fef9ef",
        detail: "#d48344"
    },
    {
        bg: "#fef9ef",
        detail: "#d48344"
    },
    {
        bg: "green lighten-5",
        detail: "green darken-2"
    },
    {
        bg: "red lighten-5",
        detail: "red accent-2"
    }
];


export const Tkupay_path_B =
    "https://finfo.ais.tku.edu.tw/pmt/PMT170/PMTSwitch?param=bnZFVDNSTmg1dU5POHdRVVk2VE5Hb0VFWjEvbk5xZ0RpUkJudmRaWS83MG1ob0tWY1l4SEFZbzY3NytsWWhPaQ=="

export const Tkupay_path_M =
    "https://finfo.ais.tku.edu.tw/pmt/PMT170/PMTSwitch?param=bnZFVDNSTmg1dU5POHdRVVk2VE5Hb0VFWjEvbk5xZ0RpUkJudmRaWS83MGJ4R2RTblVTdldtM1lHNU4yMUNXWg=="