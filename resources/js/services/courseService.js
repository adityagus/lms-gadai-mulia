import { apiInstance } from './../utils/axios.js';

export const getCourses = async (page = 1) => {
  try {
    const response = await apiInstance.get(`/courses?page=${page}`);
    return response.data;
  } catch (error) {
    console.error("Error fetching courses:", error);
    throw error;
  }
};

export const searchCourse = async () => {
  try {
    const response = await apiInstance.get(`/search`);
    return response.data;
  } catch (error) {
    console.error("Error fetching courses:", error);
    throw error;
  }
}

export const deleteCourse = async (id) => {
  try {
    const response = await apiInstance.delete(`/courses/${id}`);
    return response.data;
  } catch (error) {
    if (error.response && error.response.data) {
      console.error("Error deleting course:", error.response.data);
      throw error.response.data;
    } else {
      console.error("Error deleting course:", error);
      throw error;
    }
  }
}

export const createCourse = async (courseData) => {
  console.dir(courseData);
  try {
    const response = await apiInstance.post('/courses',courseData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
    return response.data;
  } catch (error) {
    console.error("Error creating course:", error);
    throw error;
  }
}

export const updateCourse = async (id, courseData) => {
  // console.log("courseData", courseData);die;
  try {      
    const response = await apiInstance.put(`/courses/${id}`, courseData.formData,{
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
    return response.data;
  } catch (error) {
    console.error("Error updating course:",  error.response.data);
    throw error;
  }
}

export const getCourseById = async (id, page = 1) => {
  try {
    const response = await apiInstance.get(`/preview-course/${id}`);
    return response.data;
  } catch (error) {
    console.error("Error fetching course by ID:", error);
    throw error;
  }
}

export const getCourseByIdPagination = async (id, page = 1) => {
  try {
    const response = await apiInstance.get(`/courses/${id}?page=${page}`);
    return response.data;
  } catch (error) {
    console.error("Error fetching course by ID:", error);
    throw error;
  }
}

export const getCategories = async () => {
  try {
    const response = await apiInstance.get('/categories');
    return response.data;
  } catch (error) {
    console.error("Error fetching categories:", error);
    throw error;
  }
}