import request from '@/utils/request'

export function fetchList(data) {
  return request({
    url: '/api/nav/list',
    method: 'get',
    data
  })
}

export function addNav(data) {
    return request({
        url: '/api/nav',
        method: 'post',
        data
    })
}

export function updateNav(id,data) {
    return request({
        url: '/api/nav/'+id,
        method: 'put',
        data
    })
}

export function deleteNav(id) {
    return request({
        url: '/api/nav/' + id,
        method: 'delete'
    })
}
