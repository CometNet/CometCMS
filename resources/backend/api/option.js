import request from '@/utils/request'

export function fetchList(data) {
  return request({
    url: '/api/option/list',
    method: 'get',
    data
  })
}

export function addOption(data) {
    return request({
        url: '/api/option',
        method: 'post',
        data
    })
}

export function updateOption(id,data) {
    return request({
        url: '/api/option/'+id,
        method: 'put',
        data
    })
}

export function deleteOption(id) {
    return request({
        url: '/api/option/' + id,
        method: 'delete'
    })
}
