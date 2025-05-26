import './bootstrap';
import adapter from 'webrtc-adapter';
import { v4 as uuidv4 } from 'uuid';

window.adapter = adapter;

window.uuidv4 = uuidv4;
