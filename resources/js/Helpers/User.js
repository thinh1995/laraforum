import Token from './Token.js';
import AppStorage from './AppStorage.js';

class User {
  login(data) {
    axios.post('/api/auth/login', data)
      .then((res) => this.responseAfterLogin(res))
      .catch((err) => console.log(err.response.data));
  }

  responseAfterLogin(res) {
    const { access_token } = res.data;
    const { user } = res.data;
    if (Token.isValid(access_token)) {
      AppStorage.store(access_token, user);
      window.location = '/forum';
    }
  }

  hasToken() {
    const storedToken = AppStorage.getToken();
    if (storedToken) {
      return Token.isValid(storedToken) ? true : this.logout();
    }
    return false;
  }

  loggedIn() {
    return this.hasToken();
  }

  logout() {
    AppStorage.clear();
    window.location = '/forum';
  }

  name() {
    if (this.loggedIn()) {
      return AppStorage.getUser();
    }
    return null;
  }

  id() {
    if (this.loggedIn()) {
      const payload = Token.payload(AppStorage.getToken());
      return payload.sub;
    }
    return null;
  }

  own(id) {
    return this.id() === id;
  }

  admin() {
    return this.id() === 16;
  }
}

export default User = new User();
