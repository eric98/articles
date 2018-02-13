import axios from 'axios'

class Crud {
  constructor(endPoint) {
    this.endPoint = endPoint
  }
  getAll() {
    return axios.get(this.endPoint)
  }
  update(id,newName) {
    return axios.put(this.endPoint+id,newName)
  }
  destroy(id) {
    return axios.delete(this.endPoint+id)
  }
  get(id) {
    return axios.get(this.endPoint + id)
  }
  add(resource) {
    return axios.post(this.endPoint, resource)
  }
}

export default function createApi(endPoint) {
  return new Crud(endPoint);
}