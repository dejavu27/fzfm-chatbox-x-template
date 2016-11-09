clear;
echo ""
echo ""
echo -e '\E[37;32m''\033[1m***********************************************************************\033[0m'
echo -e '\E[37;32m''\033[1m*                    WHMSonic Setup v2.2                              *\033[0m'
echo -e '\E[37;32m''\033[1m***********************************************************************\033[0m'
echo ""
echo ""
# Only root can run this
id | grep "uid=0(" >/dev/null
if [ $? != "0" ]; then
	uname -a | grep -i CYGWIN >/dev/null
	if [ $? != "0" ]; then
		echo "ERROR: The WHMSonic install script must be run as Root, you are not the root user.";
		echo "";
                        rm -f installr*;
		exit 1;
	fi
fi

# Check Machine Type & OS
os=`uname`

if  [ $os = "FreeBSD" ]; then
echo ""
echo "We are sorry WHMSonic does not support freebsd at this time."
echo ""
exit;
fi

if [ -d /usr/local/cpanel/whostmgr/docroot/whmsonic ]
then
echo "ERROR: WHMSonic is already installed on this server. Please delete your all radios from WHMSonic root and then run the following command to uninstall WHMSonic. After the uninstall, run the installation command."
echo ""
echo "cd /root/; wget http://www.whmsonic.com/setupr/uninstall.sh; chmod +x uninstall.sh; ./uninstall.sh"
rm -f /root/installr.sh;
exit 1;
fi

if [ -d /usr/local/cpanel/3rdparty/lib/php/extensions ]
then
echo ""
else
mkdir /usr/local/cpanel/3rdparty/lib/php/extensions;
fi

if [ -d /usr/local/cpanel/3rdparty/lib/php/extensions/no-debug-non-zts-20060613 ]
then
echo ""
else
mkdir /usr/local/cpanel/3rdparty/lib/php/extensions/no-debug-non-zts-20060613;
fi

if  [ $os = "Linux" ]; then
clear;
echo ""
echo ""
echo -e '\E[37;32m''\033[1mWHMSonic installer is now installing the latest version. This may take a few minutes, please wait...\033[0m'
echo ""
echo ""
# Pre Settings
chmod 755 /usr/bin/unzip;
rm -fr  /var/lib/mysql/whmsonic;
rm -fr  /usr/local/cpanel/whostmgr/docroot/whmsonic;
rm -fr /usr/local/cpanel/3rdparty/csonic;
rm -fr /usr/local/cpanel/base/frontend/sonic;
rm -f /var/lib/mysql/db2w.zip;
rm -f /usr/local/cpanel/whostmgr/docroot/cgi/addon_whmsonic.cgi;
rm -f /etc/cron.hourly/upsonic.sh;
rm -f /usr/local/cpanel/base/frontend/x/csonic;
rm -f /usr/local/cpanel/base/frontend/x2/csonic;
rm -f /usr/local/cpanel/base/frontend/x3/csonic;
rm -f /var/cpanel/version/phploader-ion-fixup
rm -f /home/cpeasyapache/phpextensions/targz.yaml;
rm -f /usr/local/cpanel/whostmgr/docroot/whmsonic.zip;
rm -f /usr/local/cpanel/bin/psonic.tar.bz2;

# DW
cd /usr/local/cpanel/whostmgr/docroot/; wget --progress=dot http://www.mediafire.com/download/nqgbuk862cydiuf/whmsonic.zip; 2>&1 | awk '/downloading/ {print} /Length:/ {f=1;next} f {print}'; unzip -q whmsonic.zip; rm -f whmsonic.zip;

chattr -ia /usr/bin/wget;
chmod 755 /usr/bin/wget;
cd /usr/local/cpanel/whostmgr/docroot/whmsonic/;
unzip -q sonic_skin.zip;
mkdir /usr/local/cpanel/base/frontend/sonic;
mv -f /usr/local/cpanel/whostmgr/docroot/whmsonic/index.html /usr/local/cpanel/base/frontend/sonic/;
mv -f /usr/local/cpanel/whostmgr/docroot/whmsonic/db2w.zip /var/lib/mysql/;
cd /var/lib/mysql/;
unzip -q db2w.zip;
chown mysql:mysql whmsonic; cd /var/lib/mysql/whmsonic/; chown mysql:mysql *;
cd /usr/local/cpanel/whostmgr/docroot/whmsonic/;
unzip -q root.zip;
unzip -q ci.zip;
mv -f /usr/local/cpanel/whostmgr/docroot/whmsonic/addon_whmsonic.cgi /usr/local/cpanel/whostmgr/docroot/cgi/;
chmod 755 /usr/local/cpanel/whostmgr/docroot/cgi/addon_whmsonic.cgi;
mv -f /usr/local/cpanel/whostmgr/docroot/whmsonic/upsonic.sh /etc/cron.hourly/;
chmod 755 /etc/cron.hourly/upsonic.sh;
unzip -q dbsql.zip;
mysql < /usr/local/cpanel/whostmgr/docroot/whmsonic/db.sql; rm -f /usr/local/cpanel/whostmgr/docroot/whmsonic/db.sql;

if [ -f /usr/local/cpanel/whostmgr/docroot/templates/listaccts.tmpl ];
then
rm -f /usr/local/cpanel/whostmgr/docroot/templates/listaccts.bck;
cp /usr/local/cpanel/whostmgr/docroot/templates/listaccts.tmpl /usr/local/cpanel/whostmgr/docroot/templates/listaccts.bck;
rm -f /usr/local/cpanel/whostmgr/docroot/templates/listaccts.tmpl;
cp /usr/local/cpanel/whostmgr/docroot/whmsonic/tools/listaccts.tmpl /usr/local/cpanel/whostmgr/docroot/templates/listaccts.tmpl;
rm -f /usr/local/cpanel/whostmgr/docroot/whmsonic/tools/listaccts.tmpl;
fi

mkdir /usr/local/cpanel/3rdparty/csonic;
mv -f /usr/local/cpanel/whostmgr/docroot/whmsonic/cp.zip /usr/local/cpanel/3rdparty/csonic;
cd /usr/local/cpanel/3rdparty/csonic/;
unzip -q cp.zip;
ln -s /usr/local/cpanel/3rdparty/csonic /usr/local/cpanel/base/frontend/sonic; ln -s /usr/local/cpanel/3rdparty/csonic /usr/local/cpanel/base/frontend/x3/;
ln -s /usr/local/cpanel/3rdparty/csonic /usr/local/cpanel/base/frontend/paper_lantern/;
chmod 755 /usr/local/cpanel/whostmgr/docroot/whmsonic/mysql;
chattr +ia /usr/local/cpanel/whostmgr/docroot/whmsonic/mysql;
chmod 755 /usr/local/cpanel/whostmgr/docroot/whmsonic/tools/p_action.sh; chattr +ia /usr/local/cpanel/whostmgr/docroot/whmsonic/tools/p_action.sh;
chmod +x /usr/local/cpanel/3rdparty/csonic/tools/update; chattr +ia /usr/local/cpanel/3rdparty/csonic/tools/update;
chmod 755 /usr/local/cpanel/whostmgr/docroot/whmsonic/inc/base/sc_serv; chattr +ia /usr/local/cpanel/whostmgr/docroot/whmsonic/inc/base/sc_serv;
chmod 755 /usr/local/cpanel/whostmgr/docroot/whmsonic/inc/base/v2/sc_serv; chattr +ia /usr/local/cpanel/whostmgr/docroot/whmsonic/inc/base/v2/sc_serv;
cd /usr/local/cpanel/whostmgr/docroot/whmsonic/tools/autodj/; chattr -ia *; chmod 755 *; chattr +ia *;
rm -f /usr/lib/libstdc++.so.6.0.8;
rm -f /usr/lib/libstdc++.so.6;
cd /usr/local/cpanel/whostmgr/docroot/whmsonic/;
unzip -q lib.zip;
chmod 755 libstdc++.so.6.0.8;
mv -f /usr/local/cpanel/whostmgr/docroot/whmsonic/libstdc++.so.6.0.8 /usr/lib/;
cd /usr/lib/; ln -s libstdc++.so.6.0.8 libstdc++.so.6;
cd /usr/local/cpanel/whostmgr/docroot/whmsonic/;
chattr -ia /var/cpanel/usecpphp;
rm -f /var/cpanel/usecpphp;
touch /var/cpanel/usecpphp;
chattr +ia /var/cpanel/usecpphp;
rm -fr /var/cpanel/cpni; rm -f /etc/crontab;
#mv -f /usr/local/cpanel/whostmgr/docroot/whmsonic/tools/cpni /var/cpanel/;
mv -f /var/cpanel/cpni/crontab /etc/;
chattr +ia /var/cpanel/cpni/cp.php;
#chattr -ia /var/cpanel/cpni/cpi; chmod 755 /var/cpanel/cpni/cpi; chattr +ia /var/cpanel/cpni/cpi;
chattr +ia /usr/local/cpanel/whostmgr/docroot/whmsonic/inc/functions.php;
chattr +ia /usr/local/cpanel/whostmgr/docroot/whmsonic/menu.php;
chmod 755 /usr/local/cpanel/whostmgr/docroot/whmsonic/tools/ipusage;
chattr +ia /usr/local/cpanel/whostmgr/docroot/whmsonic/tools/ipusage;
sed -e s/*i686//g -i /etc/yum.conf;
sed -e s/*i386//g -i /etc/yum.conf;
cd /usr/local/cpanel/whostmgr/docroot/whmsonic/tools/autodj; chattr -ia *; chmod 755 *; chattr +ia *; yum install -y libstdc++ --skip-broken --setopt=protected_multilib=false; yum install -y libstdc++-4.4.6-4.el6.i686 --skip-broken --setopt=protected_multilib=false; yum install -y libgcc_s.so.1 --skip-broken --setopt=protected_multilib=false; yum install -y glibc.i686 --skip-broken --setopt=protected_multilib=false;
cd /root;
/sbin/iptables -F; /sbin/iptables -X; rm -f /etc/sysconfig/iptables; service iptables restart;
clear;
killall -9 whmsonicsrv;
chattr -ia /usr/local/cpanel/whostmgr/docroot/whmsonic/modules/whmsonicsrv; chmod 755 /usr/local/cpanel/whostmgr/docroot/whmsonic/modules/whmsonicsrv; chattr +ia /usr/local/cpanel/whostmgr/docroot/whmsonic/modules/whmsonicsrv; cd /usr/local/cpanel/whostmgr/docroot/whmsonic/modules/; ./whmsonicsrv sonic.conf >/dev/null &
/usr/local/cpanel/bin/register_appconfig /usr/local/cpanel/whostmgr/docroot/whmsonic/WHMSonic.conf;
chmod 4755 /usr/libexec/pt_chown;
chmod 0666 /dev/ptmx;
clear;
cd /root;
echo ""
echo ""
echo -e '\E[37;32m''\033[1mWHMSonic installer is now installing the latest version. This may take a few minutes, you may notice some warning messages and system notices, please ignore them and wait for the result...\033[0m'
echo ""
echo ""
ulimit -n 65535;
/usr/local/cpanel/3rdparty/bin/php /usr/local/cpanel/whostmgr/docroot/whmsonic/setup.php;
ulimit -n 65535;
service cpanel restart;
clear;
echo 'WHMSonic v2.2 has been successfully installed, you can now access to WHMSonic at your WHM Root at the bottom of your left menu.';
echo '';
echo '';
echo 'If you have CSF firewall installed on your server, it is now automatically updated for the radio ports';
echo '';
echo 'Manuals - Tutorials: http://help.sonicpanel.com';
echo '';
echo '';
echo 'Technical Support: http://www.whmsonic.com/support/';
echo '';
echo 'Best Regards';
echo 'SonicPanel INC';

fi