import request from '@/utils/request'

export function login(data) {
  return request({
    url: '/api/user/login',
    method: 'post',
    data
  })
}

export function getInfo(token) {
  return request({
    url: '/api/user/info',
    method: 'get',
    params: { token }
  })
}

export function logout() {
  return request({
    url: '/api/user/logout',
    method: 'post'
  })
}

export function fetchList() {
    return request({
        url: '/api/user/list',
        method: 'get',
    })
}

export function addUser(data) {
    return request({
        url: '/api/user',
        method: 'post',
        data
    })
}

export function updateUser(id,data) {
    return request({
        url: '/api/user/' + id,
        method: 'put',
        data
    })
}

export function deleteUser(id) {
    return request({
        url: '/api/user/'+id,
        method: 'delete'
    })
}
