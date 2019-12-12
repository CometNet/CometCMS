import request from '@/utils/request'

export function fetchList(data) {
  return request({
    url: '/api/category/list',
    method: 'post',
    data
  })
}

export function getCategoryAllList(){
    return request({
        url: '/api/category/getAllList',
        method: 'get',
    })
}

export function fetchCategory(data) {
    return request({
        url: '/api/category/'+ data,
        method: 'get'
    })
}

export function addCategory(data) {
    return request({
        url: '/api/category',
        method: 'post',
        data
    })
}

export function updateCategory(id,data) {
    return request({
        url: '/api/category/'+id,
        method: 'put',
        data
    })
}

export function deleteCategory(id) {
    return request({
        url: '/api/category/'+id,
        method: 'delete'
    })
}
