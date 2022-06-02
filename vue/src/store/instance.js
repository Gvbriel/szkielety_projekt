import axios from "axios";

let config = {
  baseURL: "http://localhost:80/api",
  headers: {
    Authorization: `Bearer ${localStorage.getItem("token") || null}`,
    withCredentials: true,
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Methods": "*"
  },
};

axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

const instance = axios.create(config);

export default { instance };
