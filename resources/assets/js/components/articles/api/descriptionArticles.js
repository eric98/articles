import axios from 'axios'

class Crud {
  constructor(endPoint) {
    this.endPoint = endPoint
  }
  update(id,newDescription) {
    return axios.put(this.endPoint+id,newDescription)
  }
}

export default function createApi(endPoint) {
  return new Crud(endPoint);
}