# FFFields Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).


## 2.0.0 - 2019-03-21
### Added
- Added the ability to pass an element to the render methods, thus simplifying setting the value from an exisiting element.

### Changed
- Changed the way the Twig API works, `renderField()`, `renderSpecial()` and `formStart()` now all take an options array instead of lots of paramaters.

> {warning} This update will break existing templates, so please be sure to refer to the new documentation and upgrade your template code.


## 1.0.3 - 2019-03-13
### Added
- Added the option to change the submit text in the Vue API via the `submitText` and `submittingText` props

### Changed
- Moved the instructions inside the label for fields

### Fixed
- Fixed an invlid exception declaration


## 1.0.2 - 2019-02-14
### Changed
- Updated to the Craft license


## 1.0.1 - 2019-02-14
### Fixed
- Fixed an issue where the plugin wasn’t picking up valid CraftQL env vars


## 1.0.0 - 2019-02-14
### Added
- Initial release
