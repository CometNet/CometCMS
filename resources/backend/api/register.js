import request from '@/utils/request'

export function register(data) {
  return request({
    url: '/api/user/register',
    method: 'post',
    data
  })
}
