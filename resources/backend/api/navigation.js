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
        url: '/api/nav/add',
        method: 'post',
        data
    })
}

export function updateNav(data) {
    return request({
        url: '/api/nav/add',
        method: 'post',
        data
    })
}
