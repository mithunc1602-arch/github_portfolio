var board=[],turn="white",selected=null,gameStarted=false,gameOver=false,epTarget=null,castle={wK:true,wQ:true,bK:true,bQ:true},pendingPromotion=null;
var symbols={white:{king:"♔",queen:"♕",rook:"♖",bishop:"♗",knight:"♘",pawn:"♙"},black:{king:"♚",queen:"♛",rook:"♜",bishop:"♝",knight:"♞",pawn:"♟"}};

function initialBoard(){return[
["black-rook","black-knight","black-bishop","black-queen","black-king","black-bishop","black-knight","black-rook"],
["black-pawn","black-pawn","black-pawn","black-pawn","black-pawn","black-pawn","black-pawn","black-pawn"],
["","","","","","","",""],["","","","","","","",""],["","","","","","","",""],["","","","","","","",""],
["white-pawn","white-pawn","white-pawn","white-pawn","white-pawn","white-pawn","white-pawn","white-pawn"],
["white-rook","white-knight","white-bishop","white-queen","white-king","white-bishop","white-knight","white-rook"]]}

function color(p){return p?p.split("-")[0]:""} function type(p){return p?p.split("-")[1]:""}
function inside(r,c){return r>=0&&r<8&&c>=0&&c<8}
function clone(b){return b.map(function(r){return r.slice()})}
function findKing(b,col){for(var r=0;r<8;r++)for(var c=0;c<8;c++)if(b[r][c]==col+"-king")return[r,c];return null}

function attacksSquare(b,fr,fc,tr,tc){
 var p=b[fr][fc], col=color(p), t=type(p), dr=tr-fr, dc=tc-fc, adr=Math.abs(dr), adc=Math.abs(dc);
 if(!p)return false;
 if(t=="pawn"){var d=col=="white"?-1:1;return dr==d&&adc==1}
 if(t=="knight")return(adr==2&&adc==1)||(adr==1&&adc==2);
 if(t=="king")return Math.max(adr,adc)==1;
 if(t=="rook"&&(dr==0||dc==0)||t=="bishop"&&(adr==adc)||t=="queen"&&((dr==0||dc==0)||(adr==adc))){
   var sr=dr==0?0:dr/adr, sc=dc==0?0:dc/adc, r=fr+sr,c=fc+sc;
   while(r!=tr||c!=tc){if(b[r][c])return false;r+=sr;c+=sc}
   return true;
 }
 return false;
}
function inCheck(b,col){
 var k=findKing(b,col); if(!k)return true;
 var enemy=col=="white"?"black":"white";
 for(var r=0;r<8;r++)for(var c=0;c<8;c++)if(color(b[r][c])==enemy&&attacksSquare(b,r,c,k[0],k[1]))return true;
 return false;
}
function pseudoMoves(b,r,c,includeKingSafety){
 var p=b[r][c],col=color(p),t=type(p),out=[];
 if(!p)return out;
 function add(rr,cc){if(!inside(rr,cc))return false;if(!b[rr][cc]||color(b[rr][cc])!=col)out.push([rr,cc]);return !b[rr][cc]}
 if(t=="pawn"){
   var d=col=="white"?-1:1,start=col=="white"?6:1;
   if(inside(r+d,c)&&!b[r+d][c]){out.push([r+d,c]);if(r==start&&!b[r+2*d][c])out.push([r+2*d,c])}
   for(var dc=-1;dc<=1;dc+=2)if(inside(r+d,c+dc)&&b[r+d][c+dc]&&color(b[r+d][c+dc])!=col)out.push([r+d,c+dc]);
   if(epTarget&&epTarget[0]==r+d&&epTarget[1]==c+(epTarget[2]))out.push([epTarget[0],epTarget[1]]);
 }else if(t=="knight"){[[2,1],[2,-1],[-2,1],[-2,-1],[1,2],[1,-2],[-1,2],[-1,-2]].forEach(function(x){add(r+x[0],c+x[1])})}
 else if(t=="king"){
   for(var rr=-1;rr<=1;rr++)for(var cc=-1;cc<=1;cc++)if(rr||cc)add(r+rr,c+cc);
   if(!includeKingSafety)return out;
   var row=col=="white"?7:0;
   if(r==row&&c==4&&!inCheck(b,col)){
     if((col=="white"?castle.wK:castle.bK)&&b[row][5]==""&&b[row][6]==""&&!attacksSquare(b,row,7,row,5)&&!attacksSquare(b,row,7,row,6))out.push([row,6]);
     if((col=="white"?castle.wQ:castle.bQ)&&b[row][1]==""&&b[row][2]==""&&b[row][3]==""&&!attacksSquare(b,row,0,row,3)&&!attacksSquare(b,row,0,row,2))out.push([row,2]);
   }
 }else{
   var dirs=t=="rook"?[[1,0],[-1,0],[0,1],[0,-1]]:t=="bishop"?[[1,1],[1,-1],[-1,1],[-1,-1]]:[[1,0],[-1,0],[0,1],[0,-1],[1,1],[1,-1],[-1,1],[-1,-1]];
   dirs.forEach(function(d){var rr=r+d[0],cc=c+d[1];while(inside(rr,cc)){if(!b[rr][cc])out.push([rr,cc]);else{if(color(b[rr][cc])!=col)out.push([rr,cc]);break}rr+=d[0];cc+=d[1]}})
 }
 return out;
}
function legalMoves(b,r,c){
 var p=b[r][c],col=color(p),res=[],moves=pseudoMoves(b,r,c,true);
 moves.forEach(function(m){
   var nb=clone(b),moving=nb[r][c],capt=nb[m[0]][m[1]];
   nb[m[0]][m[1]]=moving;nb[r][c]="";
   if(type(moving)=="pawn"&&epTarget&&m[0]==epTarget[0]&&m[1]==epTarget[1]&&!capt)nb[r+(col=="white"?-1:1)][m[1]]="";
   if(type(moving)=="king"&&Math.abs(m[1]-c)==2){if(m[1]==6){nb[r][5]=nb[r][7];nb[r][7]=""}else{nb[r][3]=nb[r][0];nb[r][0]=""}}
   if(!inCheck(nb,col))res.push(m);
 });return res;
}
function hasMove(col){for(var r=0;r<8;r++)for(var c=0;c<8;c++)if(color(board[r][c])==col&&legalMoves(board,r,c).length)return true;return false}
function draw(){
 var el=document.getElementById("board");el.innerHTML="";
 for(var r=0;r<8;r++)for(var c=0;c<8;c++){var s=document.createElement("div");s.className="square "+(((r+c)%2)?"dark":"light");if(selected&&selected[0]==r&&selected[1]==c)s.className+=" selected";
   if(selected){var ms=legalMoves(board,selected[0],selected[1]);for(var i=0;i<ms.length;i++)if(ms[i][0]==r&&ms[i][1]==c)s.className+=board[r][c]?" capture":" legal"}
   s.innerHTML=board[r][c]?symbols[color(board[r][c])][type(board[r][c])]:"";s.onclick=(function(rr,cc){return function(){clickSquare(rr,cc)}})(r,c);el.appendChild(s)}
 document.getElementById("turnText").innerHTML=turn.charAt(0).toUpperCase()+turn.slice(1);
}
function clickSquare(r,c){
 if(!gameStarted||gameOver)return;
 var p=board[r][c];
 if(!selected){if(color(p)==turn){selected=[r,c];setStatus("Select a destination square.")}}
 else{
   var ms=legalMoves(board,selected[0],selected[1]),ok=false;for(var i=0;i<ms.length;i++)if(ms[i][0]==r&&ms[i][1]==c)ok=true;
   if(ok)makeMove(selected[0],selected[1],r,c);else if(color(p)==turn){selected=[r,c];setStatus("Piece selected.")}else{setStatus("Illegal move.")}
 }
 draw();
}
function makeMove(fr,fc,tr,tc){
 var p=board[fr][fc],col=color(p),t=type(p),capt=board[tr][tc];
 if(t=="pawn"&&epTarget&&tr==epTarget[0]&&tc==epTarget[1]&&!capt)board[fr][tc]="";
 board[tr][tc]=p;board[fr][fc]="";
 if(t=="king"&&Math.abs(tc-fc)==2){if(tc==6){board[tr][5]=board[tr][7];board[tr][7]=""}else{board[tr][3]=board[tr][0];board[tr][0]=""}}
 if(t=="king"){if(col=="white"){castle.wK=false;castle.wQ=false}else{castle.bK=false;castle.bQ=false}}
 if(t=="rook"){if(fr==7&&fc==0)castle.wQ=false;if(fr==7&&fc==7)castle.wK=false;if(fr==0&&fc==0)castle.bQ=false;if(fr==0&&fc==7)castle.bK=false}
 if(capt&&type(capt)=="rook"){if(tr==7&&tc==0)castle.wQ=false;if(tr==7&&tc==7)castle.wK=false;if(tr==0&&tc==0)castle.bQ=false;if(tr==0&&tc==7)castle.bK=false}
 epTarget=null;if(t=="pawn"&&Math.abs(tr-fr)==2)epTarget=[(fr+tr)/2,fc,0];
 if(t=="pawn"&&tr==(col=="white"?0:7)){pendingPromotion=[tr,tc];document.getElementById("promotion").className="promotion";selected=null;return}
 finishTurn();
}
function finishTurn(){
 selected=null;turn=turn=="white"?"black":"white";
 var check=inCheck(board,turn),moves=hasMove(turn);
 if(!moves){gameOver=true;if(check){var winner=turn=="white"?document.getElementById("blackPlayer").value:document.getElementById("whitePlayer").value;setStatus("Checkmate! "+winner+" wins.")}else setStatus("Stalemate. Draw.")}else setStatus(check?"Check!":"Game in progress.");
 draw();
}
function promote(t){var col=turn=="white"?"white":"black";board[pendingPromotion[0]][pendingPromotion[1]]=col+"-"+t;pendingPromotion=null;document.getElementById("promotion").className="promotion hidden";finishTurn()}
function startGame(){var w=document.getElementById("whitePlayer").value.trim(),b=document.getElementById("blackPlayer").value.trim();if(!w||!b){alert("Enter both player names.");return}board=initialBoard();turn="white";selected=null;gameStarted=true;gameOver=false;epTarget=null;castle={wK:true,wQ:true,bK:true,bQ:true};setStatus("Game started. White moves first.");draw()}
function resetGame(){board=initialBoard();turn="white";selected=null;gameStarted=false;gameOver=false;epTarget=null;castle={wK:true,wQ:true,bK:true,bQ:true};setStatus("Enter player names and click Start Game.");draw()}
function setStatus(x){document.getElementById("statusText").innerHTML=x}
function saveResult(){
 if(!gameOver){alert("Finish the game before saving the result.");return}
 var text=document.getElementById("statusText").innerHTML,w=document.getElementById("whitePlayer").value,b=document.getElementById("blackPlayer").value;
 var winner=text.indexOf("wins.")>=0?text.substring(text.indexOf("! ")+2,text.indexOf(" wins.")):"Draw";
 var result=text.indexOf("Checkmate")>=0?"Checkmate": "Draw";
 var f=document.createElement("form");f.method="post";f.action="save_game.php";
 [["white_player",w],["black_player",b],["winner",winner],["result",result]].forEach(function(a){var i=document.createElement("input");i.type="hidden";i.name=a[0];i.value=a[1];f.appendChild(i)});document.body.appendChild(f);f.submit()
}
window.onload=function(){resetGame()}
