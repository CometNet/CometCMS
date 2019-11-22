import request from '@/utils/request'

export function fetchSlideClassifyList(data) {
  return request({
    url: '/api/slide_classify/list',
    method: 'get',
    data
  })
}

export function getSlideClassifyAllList() {
    return request({
        url: '/api/slide_classify/all',
        method: 'get'
    })
}

export function addSlideClassify(data) {
    return request({
        url: '/api/slide_classify',
        method: 'post',
        data
    })
}

export function updateSlideClassify(id,data) {
    return request({
        url: '/api/slide_classify/' + id,
        method: 'put',
        data
    })
}

export function deleteSlideClassify(id) {
    return request({
        url: '/api/slide_classify/' + id,
        method: 'delete'
    })
}


export function fetchSlideList(data,id) {
    return request({
        url: '/api/slide/list?slide_id='+id,
        method: 'post',
        data
    })
}

export function addSlide(data) {
    return request({
        url: '/api/slide',
        method: 'post',
        data
    })
}

export function updateSlide(id,data) {
    return request({
        url: '/api/slide/'+id,
        method: 'put',
        data
    })
}

export function deleteSlide(id) {
    return request({
        url: '/api/slide/' + id,
        method: 'delete'
    })
}
