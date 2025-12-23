import { http } from "./http" 

export async function fetchPets() {
  const { data } = await http.get('/pets')
  return data
}

export async function deletePet(petId) {
  await http.delete(`/pets/${petId}`)
}

export async function createPet(payload) {
  const { data } = await http.post('/pets', payload)
  return data
}

export async function updatePet(id, payload) {
  const { data } = await http.put(`/pets/${id}`, payload) 
  return data
}

export async function fetchPetById(id) {
  const { data } = await http.get(`/pets/${id}`)
  return data
}

export async function adoptPet(id, payload) {
  const { data } = await http.patch(`/pets/${id}/adoption`, payload) 
  return data
}