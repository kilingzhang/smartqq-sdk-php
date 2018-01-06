<?php
/**
 * Created by kilingzhang
 * User: kilingzhang.com
 * Date: 18-1-5
 * Time: 下午1:17
 */

namespace kilingzhang\SmartQQ;


class URL
{
    const qrcodeURL = 'https://ssl.ptlogin2.qq.com/ptqrshow?appid=501004106&e=2&l=M&s=3&d=72&v=4&daid=164&pt_3rd_aid=0';

    const ptqrloginURL = 'https://ssl.ptlogin2.qq.com/ptqrlogin?u1=http%3A%2F%2Fw.qq.com%2Fproxy.html&ptredirect=0&h=1&t=1&g=1&from_ui=1&ptlang=2052&js_ver=10233&js_type=1&login_sig=&pt_uistyle=40&aid=501004106&daid=164&mibao_css=m_webqq';

    const getvfwebqqURL = 'http://s.web2.qq.com/api/getvfwebqq?ptwebqq=&clientid=53999199&psessionid=';

    const login2URL = 'http://d1.web2.qq.com/channel/login2';

    /**
     * POST
     * r:{"vfwebqq":"19fc2f1bced2e9df0d364efbd16c1535bb961bafb69c821505dd48935749cf24343ff16dab7fecb2","hash":"001500EC00F6000F"}
     *
     */
    const getUserFriendsURL = 'http://s.web2.qq.com/api/get_user_friends2';

    /**
     * POST
     * r:{"vfwebqq":"19fc2f1bced2e9df0d364efbd16c1535bb961bafb69c821505dd48935749cf24343ff16dab7fecb2","hash":"001500EC00F6000F"}
     */
    const getGroupNameListURL = 'http://s.web2.qq.com/api/get_group_name_list_mask2';

    /**
     * GET
     * http://s.web2.qq.com/api/get_discus_list?
     * clientid=53999199
     * &psessionid=8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857
     * &vfwebqq=19fc2f1bced2e9df0d364efbd16c1535bb961bafb69c821505dd48935749cf24343ff16dab7fecb2
     * &t=1515240451637
     */
    const getDiscusListURL = 'http://s.web2.qq.com/api/get_discus_list';

    /**
     * GET
     * http://s.web2.qq.com/api/get_self_info2?
     * t=1515240451637
     */
    const getSelfInfoURL = 'http://s.web2.qq.com/api/get_self_info2?t=1515239051347';

    /**
     * GET
     * http://d1.web2.qq.com/channel/get_online_buddies2?
     * vfwebqq=19fc2f1bced2e9df0d364efbd16c1535bb961bafb69c821505dd48935749cf24343ff16dab7fecb2
     * &clientid=53999199
     * &psessionid=8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857
     * &t=1515240454784
     */
    const getOnlineBuddiesURL = 'Request URL:http://d1.web2.qq.com/channel/get_online_buddies2';

    /**
     * POST
     * r:{"vfwebqq":"19fc2f1bced2e9df0d364efbd16c1535bb961bafb69c821505dd48935749cf24343ff16dab7fecb2","clientid":53999199,"psessionid":"8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857"}
     */
    const getRecentListURL = 'http://d1.web2.qq.com/channel/get_recent_list2';

    /**
     * POST
     * r:{"ptwebqq":"","clientid":53999199,"psessionid":"8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857","key":""}
     */
    const pollURL = 'http://d1.web2.qq.com/channel/poll2';

    /**
     * GET
     * http://s.web2.qq.com/api/get_group_info_ext2?
     * gcode=3508844965
     * &vfwebqq=19fc2f1bced2e9df0d364efbd16c1535bb961bafb69c821505dd48935749cf24343ff16dab7fecb2
     * &t=1515240567342
     */
    const getGroupInfoURL = 'http://s.web2.qq.com/api/get_group_info_ext2';

    /**
     * GET
     * http://d1.web2.qq.com/channel/get_discu_info?
     * did=2432743258
     * &vfwebqq=19fc2f1bced2e9df0d364efbd16c1535bb961bafb69c821505dd48935749cf24343ff16dab7fecb2
     * &clientid=53999199&psessionid=8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857
     * &t=1515241015252
     */
    const getDiscusInfoURL = 'http://d1.web2.qq.com/channel/get_discu_info';

    /**
     * GET
     * http://s.web2.qq.com/api/get_friend_info2?
     * tuin=3057008456
     * &vfwebqq=19fc2f1bced2e9df0d364efbd16c1535bb961bafb69c821505dd48935749cf24343ff16dab7fecb2
     * &clientid=53999199
     * &psessionid=8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857
     * &t=1515240882826
     */
    const getFriendInfoURL = 'http://s.web2.qq.com/api/get_friend_info2';

    /**
     * GET
     * http://s.web2.qq.com/api/get_single_long_nick2?
     * tuin=3057008456
     * &vfwebqq=19fc2f1bced2e9df0d364efbd16c1535bb961bafb69c821505dd48935749cf24343ff16dab7fecb2
     * &t=1515240882825
     */
    const getSingleLongNickURL = 'http://s.web2.qq.com/api/get_single_long_nick2';

    /**
     * POST
     * r:{
     *  "to":3057008456,
     *  "content":"["1",["font",{"name":"宋体","size":10,"style":[0,0,0],"color":"000000"}]]",
     *  "face":594,
     *  "clientid":53999199,
     *  "msg_id":4490001,
     *  "psessionid":"8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857"
     *  }
     */
    const sendPrivateMessageURL = 'http://d1.web2.qq.com/channel/send_buddy_msg2';

    /**
     * POST
     * r:{
     *   "group_uin":736603276,
     *   "content":"[["face",3]," ",["font",{"name":"宋体","size":10,"style":[0,0,0],"color":"000000"}]]",
     *   "face":594,
     *   "clientid":53999199,
     *  "msg_id":4490002,
     *  "psessionid":"8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857"
     *  }
     */
    const sendGroupMessageURL = 'http://d1.web2.qq.com/channel/send_qun_msg2';

    /**
     * POST
     * r:{
     *   "did":470891918,
     *  "content":"[["face",3]," ",["font",{"name":"宋体","size":10,"style":[0,0,0],"color":"000000"}]]",
     *  "face":594,
     *  "clientid":53999199,
     *  "msg_id":4490003,
     *  "psessionid":"8368046764001d636f6e6e7365727665725f77656271714031302e3133332e34312e383400001ad00000066b026e040015808a206d0000000a406172314338344a69526d0000002859185d94e66218548d1ecb1a12513c86126b3afb97a3c2955b1070324790733ddb059ab166de6857"
     *  }
     */
    const sendDiscusMessageURL = 'http://d1.web2.qq.com/channel/send_discu_msg2';



}