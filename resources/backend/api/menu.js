import request from '@/utils/request'

export function fetchList(data,navid) {
  return request({
    url: '/api/menu/list?navid=' + navid,
    method: 'post',
    data
  })
}

export function getNavList() {
    return request({
        url: '/api/nav/all',
        method: 'get'
    })
}

export function addMenu(data) {
    return request({
        url: '/api/menu',
        method: 'post',
        data
    })
}

export function updateMenu(id,data) {
    return request({
        url: '/api/menu/'+id,
        method: 'put',
        data
    })
}

export function deleteMenu(id) {
    return request({
        url: '/api/menu/'+id,
        method: 'delete'
    })
}
