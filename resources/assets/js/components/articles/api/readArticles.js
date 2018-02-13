import axios from 'axios'

class Crud {
  constructor(endPoint) {
    this.endPoint = endPoint
  }
  destroy(id) {
    return axios.delete(this.endPoint+id)
  }
  store(id) {
    return axios.post(this.endPoint+id)
  }
}

export default function createApi(endPoint) {
  return new Crud(endPoint);
}