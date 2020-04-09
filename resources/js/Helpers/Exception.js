import User from './User.js';

class Exception {
  constructor() {
    this.listError = [
      'Token can not be used, get new one',
      'Token is invalid',
      'Token is expired',
    ];
  }

  handle(error) {
    this.isExpired(error.response.data.error);
  }

  isExpired(error) {
    if (this.listError.includes(error)) {
      User.logout();
    }
  }
}

export default Exception = new Exception();
