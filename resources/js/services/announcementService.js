import { apiInstance } from '../utils/axios';

export const getAnnouncements = async (category) => {
  try {
    const response = await apiInstance.get('/announcements', {
      params: { category }
    });
    return response.data;
  } catch (error) {
    console.error('Error fetching announcements:', error);
    throw error;
  }
}

export const getDetailAnnouncement = async (id) => {
  try {
    const response = await apiInstance.get(`/announcement/${id}`);
    return response.data;
  } catch (error) {
    console.error('Error fetching announcement details:', error);
    throw error;
  }
}

export const getDocumentById = async (document_id) => {
  try {
    const response = await apiInstance.get(`/announcements/document/${document_id}`);
    console.log(response);
    return response.data;
  } catch (error) {
    console.error('Error fetching document by ID:', error);
    throw error;
  }
}

export const createAnnouncement = async (data) => {
  try {
    const response = await apiInstance.post('/announcements', data);
    return response.data;
  } catch (error) {
    console.error('Error creating announcement:', error);
    throw error;
  }
}

export const updateAnnouncement = async (data, id) => {
  try {
    const response = await apiInstance.post(`/announcements/${id}`, data);
    return response.data;
  } catch (error) {
    console.error('Error updating announcement:', error);
    throw error;
  }
}

export const softDeleteAnnouncement = async (id) => {
  try {
    const response = await apiInstance.delete(`/announcements/${id}`);
    return response.data;
  } catch (error) {
    console.error('Error deleting announcement:', error);
    throw error;
  }
}

export const trashAnnouncement = async (submenu_id) => {
  try {
    const response = await apiInstance.get('/announcements/trash', {
      params: { category: submenu_id }
    });
    console.log('response', response);
    return response.data;
  } catch (error) {
    console.error('Error fetching trashed announcements:', error);
    throw error;
  }
}

export const restoreAnnouncement = async (id) => {
  try {
    const response = await apiInstance.patch(`/announcements/${id}/restore`);
    return response.data;
  } catch (error) {
    console.error('Error restoring announcement:', error);
    throw error;
  }
}

export const hardDeleteAnnouncement = async (id) => {
  try {
    const response = await apiInstance.delete(`/announcements/hardDelete/${id}`);
    return response.data;
  } catch (error) {
    console.error('Error permanently deleting announcement:', error);
    throw error;
  }
}

export const wizardSession = async () => {
  try {
    const response = await apiInstance.get('/wizard/session');
    return response.data;
  } catch (error) {
    console.error('Error fetching wizard session:', error);
    throw error;
  }
}

export const wizardStep = async (step, data) => {
  try {
    const response = await apiInstance.post(`/wizard/step/${step}`, { data });
    return response.data;
  } catch (error) {
    console.error('Error saving wizard step:', error);
    throw error;
  }
}

export const finishWizard = async () => {
  try {
    const response = await apiInstance.post('/wizard/finish');
    return response.data;
  } catch (err) {
    console.error('Error finishing wizard:', err);
    throw err;
  }
}

