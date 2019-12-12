import request from '@/utils/request'

export function fetchList(data) {
  return request({
    url: '/api/article/list',
    method: 'post',
    data
  })
}

export function fetchArticle(data) {
    return request({
        url: '/api/article/'+ data,
        method: 'get'
    })
}

export function addArticle(data) {
    return request({
        url: '/api/article',
        method: 'post',
        data
    })
}

export function updateArticle(id,data) {
    return request({
        url: '/api/article/'+id,
        method: 'put',
        data
    })
}

export function deleteArticle(id) {
    return request({
        url: '/api/article/'+id,
        method: 'delete'
    })
}
