import axios from 'axios'

class Crud {
  constructor(endPoint) {
    this.endPoint = endPoint
  }
  update(id,newUserId) {
    return axios.put(this.endPoint+id,newUserId)
  }
}

export default function createApi(endPoint) {
  return new Crud(endPoint);
}