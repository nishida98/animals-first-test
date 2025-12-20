import { http } from "./http" 

export async function fetchPets() {
  const { data } = await http.get('/pets')
  return data
}

export async function deletePet(petId) {
  await http.delete(`/pets/${petId}`)
}