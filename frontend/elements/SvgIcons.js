import React from 'react';
import HomeSvg from '../assets/icons/Home.svg';
import ActivitySvg from '../assets/icons/History.svg';
import UserSvg from '../assets/icons/User.svg';
import PhoneSvg from '../assets/icons/Phone.svg';
import SecuritySvg from '../assets/icons/Security.svg';
import EmailSvg from '../assets/icons/Email.svg';
import LogoutSvg from '../assets/icons/Logout.svg';
import SupportSvg from '../assets/icons/Support.svg';
import See from '../assets/icons/See.svg';

const SvgIcons = {
  Home: ({ width = 24, height = 24, fill = 'grey' }) => (
    <HomeSvg width={width} height={height} fill={fill} />
  ),
  Activity: ({ width = 24, height = 24, fill = 'grey' }) => (
    <ActivitySvg width={width} height={height} fill={fill} />
  ),
  User: ({ width = 24, height = 24, fill = 'grey' }) => (
    <UserSvg width={width} height={height} fill={fill} />
  ),
  Phone: ({ width = 24, height = 24, fill = 'grey' }) => (
    <PhoneSvg width={width} height={height} fill={fill} />
  ),
  Security: ({ width = 24, height = 24, fill = 'grey' }) => (
    <SecuritySvg width={width} height={height} fill={fill} />
  ),
  Email: ({ width = 24, height = 24, fill = 'grey' }) => (
    <EmailSvg width={width} height={height} fill={fill} />
  ),
  Support: ({ width = 24, height = 24, fill = 'grey' }) => (
    <SupportSvg width={width} height={height} fill={fill} />
  ),
  Logout: ({ width = 24, height = 24, fill = 'grey' }) => (
    <LogoutSvg width={width} height={height} fill={fill} />
  ),
  See: ({ width = 24, height = 24, fill = 'grey' }) => (
    <See width={width} height={height} fill={fill} />
  ),
};

export default SvgIcons;
