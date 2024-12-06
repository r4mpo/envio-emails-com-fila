import axios from 'axios';

const URL_BASE = 'http://127.0.0.1:8000/api/';

export function getData(path) {
  return axios.get(URL_BASE + path)
    .then(response => {
      return response.data;
    }).catch(error => {
      return error;
    });
}

export function postData(path, body) {
    return axios.post(URL_BASE + path, body)
    .then(response => {
      return response.data;
    }).catch(error => {
      return error;
    });
  }
  