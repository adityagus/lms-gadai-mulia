import { apiInstance } from "../utils/axios";

export const getContentsByCourseId = async (courseId) => {
  try {
    const response = await apiInstance.get(`/course/contents/${courseId}`);
    return response.data;
    
  } catch (error) {
    console.error('Error fetching contents by course ID:', error);
    throw error;
  }
};

export const getContentById = async (id) => {
  try {
    const response = await apiInstance.get(`/contents/${id}`);
    return response.data;
  } catch (error) {
    console.error('Error fetching content by ID:', error);
    throw error;
  }
};

export const createContent = async (data) => {
  console.log('Creating content with data:', data);
  const response = await apiInstance.post('/contents', data);
  return response.data;
};

export const updateContent = async (data) => {
  console.log('Updating content with data:', data);
  const { id, ...updateData } = data; // Remove id from data body
  const response = await apiInstance.put(`/contents/${id}`, updateData, {
      headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
      },
  });
  return response.data;
};

export const deleteContent = async (id) => {
  const response = await apiInstance.delete(`/contents/${id}`);
  return response.data;
};
