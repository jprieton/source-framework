class KeyEvent {
  static isTab(event) {
    return (!event.shiftKey && event.keyCode === 9);
  }

  static isBackTab(event) {
    return (event.shiftKey && event.keyCode === 9);
  }

  static isHome(event) {
    return (event.keyCode === 36);
  }

  static isEnd(event) {
    return (event.keyCode === 35);
  }

  static isPageDown(event) {
    return (event.keyCode === 34);
  }

  static isPageUp(event) {
    return (event.keyCode === 33);
  }

  static isDelete(event) {
    return (event.keyCode === 46);
  }

  static isBackspace(event) {
    return (event.keyCode === 8);
  }

  static isSpace(event) {
    return (event.keyCode === 32);
  }

  static isArrow(event) {
    return (event.charCode >= 37 && event.charCode <= 40);
  }

  static isEnter(event) {
    return ((!event.ctrlKey || !event.shiftKey) && event.keyCode === 13);
  }

  static isNumeric(event) {
    return ((!event.ctrlKey || !event.shiftKey) && (event.charCode >= 48 && event.charCode <= 57));
  }

  static isAllowedNavigation(event) {
    return (this.isArrow(event) || this.isTab(event) || this.isBackTab(event) || this.isHome(event) || this.isEnd(event));
  }

  static isAllowedPaged(event) {
    return (this.isPageDown(event) || this.isPageUp(event));
  }

  static isAllowedDefault(event) {
    return (this.isAllowedPaged(event) || this.isAllowedNavigation(event) || this.isDelete(event) || this.isBackspace(event));
  }

  static isAlpha(event) {
    //Warning This only validates if in english alfabetic character
    var isAlpha = (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 65 && event.charCode <= 90);
    return (!event.ctrlKey && isAlpha);
  }

}
