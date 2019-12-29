import request from '@/utils/request'

export function upload(blob,name) {
    let formData = new window.FormData();
    formData.append('file', blob, name);
    return request({
        url: '/api/upload/file',
        method: 'post',
        headers: {
            "Content-Type": 'form-data'
        },
        data: formData
    })
}
