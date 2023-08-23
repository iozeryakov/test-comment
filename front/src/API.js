import axios from "axios";
const API_URL = "http://localhost/php-mysql";

export function getAll() {
  return axios.get(`${API_URL}/read.php`);
}
export function deleteComment(id) {
  return axios.delete(`${API_URL}/delete.php`, { params: { id: id } });
}
export function createComment(user) {
  return axios.post(`${API_URL}/create.php`, user);
}
